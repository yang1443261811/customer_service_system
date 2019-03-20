<?php

namespace App\Http\Controllers;

use App\ChatLog;
use App\WorkOrder;
use GatewayClient\Gateway;
use Illuminate\Http\Request;
use App\Http\Requests\StoreChatMessage;

class ServerController extends Controller
{
    protected $chat;

    /**
     * ServerController constructor.
     */
    public function __construct()
    {
        Gateway::$registerAddress = '127.0.0.1:1238';

        $this->chat = new ChatLog();
    }

    /**
     * 将聊天用户加入组内
     *
     * @param Request $request
     * @param string $client_id
     */
    public function joinGroup(Request $request, $client_id)
    {
        $group_id = $request->input('group_id');
        //将用户的所在组保存到session中
        Gateway::setSession($client_id, ['group_id' => $group_id]);
        //将用户加入组内
        Gateway::joinGroup($client_id, $group_id);
    }

    /**
     * 发送消息
     *
     * @param StoreChatMessage $request
     * @param $client_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function send(StoreChatMessage $request, $client_id)
    {
        //根据client_id获取用户所在组,如果没有获取到直接返回
        if (!$session = Gateway::getSession($client_id)) {
            return response()->json(false);
        }

        //消息入库
        $result = $this->chat->fill($request->all())->save();
        //累加未读消息数
        WorkOrder::where('id', $request->wo_id)->increment('server_msg_unread_count', 1);

        $message = [
            'message_type' => 'chatMessage',
            'data' => [
                'id'           => $request['from_id'],
                'name'         => $request['from_name'],
                'avatar'       => $request['from_avatar'],
                'time'         => date('Y-m-d H:i:s'),
                'content'      => $request['content'],
                'wo_id'        => $request['wo_id'],
                'content_type' => $request['content_type'],
            ]
        ];
        //将消息内容推送给用户所在组的人
        Gateway::sendToGroup($session['group_id'], json_encode($message), [$client_id]);

        return response()->json($result);
    }

    /**
     * 发送消息客服专用
     *
     * @param StoreChatMessage $request
     * @param string $client_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function send_by_kf(StoreChatMessage $request, $client_id)
    {
        //根据client_id获取用户所在组,如果没有获取到直接返回
        if (!$session = Gateway::getSession($client_id)) {
            return response()->json(false);
        }

        //消息入库
        $result = $this->chat->fill($request->all())->save();
        //累加未读消息数
        WorkOrder::where('id', $request->wo_id)->increment('client_msg_unread_count', 1);

        //如果是未经受理的新工单,那么将当前客服作为工单的受理人,并将工单的状态更改为2(表示已接收处理)
        if (WorkOrder::isNew($request->wo_id)) {
            WorkOrder::setStatus($request->wo_id, 2);
        }

        $message = [
            'message_type' => 'chatMessage',
            'data' => [
                'id'           => $request['from_id'],
                'name'         => $request['from_name'],
                'avatar'       => $request['from_avatar'],
                'time'         => date('Y-m-d H:i:s'),
                'content'      => $request['content'],
                'wo_id'        => $request['wo_id'],
                'content_type' => $request['content_type'],
            ]
        ];
        //将消息内容推送给用户所在组的人
        Gateway::sendToGroup($session['group_id'], json_encode($message), [$client_id]);

        return response()->json($result);
    }
}
