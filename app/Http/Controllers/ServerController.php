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
    public function join(Request $request, $client_id)
    {
        $uid = $request->input('uid');
        // client_id与uid绑定
        Gateway::bindUid($client_id, $uid);
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
        //消息入库
        $result = $this->chat->fill($request->all())->save();
        //累加未读消息数
        WorkOrder::where('id', $request->wo_id)->increment('server_msg_unread_count', 1);

        //如果接收用户的ID不为空并且这个用户在线就将消息推送给用户
        if (!is_null($request['kf_id'])) {
            $message = [
                'message_type' => 'new_message',
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

            Gateway::sendToUid($request['kf_id'], json_encode($message));
        }

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
        //消息入库
        $result = $this->chat->fill($request->all())->save();
        //累加未读消息数
        WorkOrder::where('id', $request->wo_id)->increment('client_msg_unread_count', 1);

        //如果消息所属的工单是新工单,那么将当前客服作为工单的受理人,并将工单的状态更改为2(表示已接收处理)
        if ($request->status == 1) {
            WorkOrder::setStatus($request->wo_id, 2);
        }

        $message = [
            'message_type' => 'new_message',
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

        Gateway::sendToUid($request['to_id'], json_encode($message));

        return response()->json($result);
    }
}
