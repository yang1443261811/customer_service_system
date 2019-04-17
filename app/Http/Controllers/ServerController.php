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
     * @param int $uid
     * @param string $client_id
     */
    public function join($uid, $client_id)
    {
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
        $result = ChatLog::insertMessage($request->all());
        //累加未读消息数
        WorkOrder::set_service_msg_count($request->wo_id, 'up');

        //如果接收用户的ID不为空就将消息推送给接收方
        if (!is_null($request['kf_id'])) {
            $message = $this->msgFactory($request->all(), 'new_message');

            Gateway::sendToUid($request['kf_id'], $message);
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
        $result = ChatLog::insertMessage($request->all());
        //累加未读消息数
        WorkOrder::set_client_msg_count($request->wo_id, 'up');

        //如果消息所属的工单是新工单,那么将当前客服作为工单的受理人,并将工单的状态更改为2(表示已接收处理)
        $request->status == 1 && WorkOrder::setStatus($request->wo_id, 2);

        $message = $this->msgFactory($request->all(), 'new_message');
        //将消息推送给接收用户
        Gateway::sendToUid($request['to_id'], $message);

        return response()->json($result);
    }

    /**
     * 构造消息
     *
     * @param array $data 包含消息参数的数组
     * @param string $type 消息的类型
     * @return string
     */
    public function msgFactory(array $data, $type)
    {
        return json_encode([
            'message_type' => $type,
            'data' => [
                'id'           => $data['from_id'],
                'name'         => $data['from_name'],
                'avatar'       => $data['from_avatar'],
                'time'         => date('Y-m-d H:i:s'),
                'content'      => $data['content'],
                'wo_id'        => $data['wo_id'],
                'content_type' => $data['content_type'],
            ]
        ]);
    }
}
