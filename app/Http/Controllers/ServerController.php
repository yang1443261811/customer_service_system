<?php

namespace App\Http\Controllers;

use App\ChatLog;
use GatewayClient\Gateway;
use Illuminate\Http\Request;
use App\Http\Requests\StoreChatMessage;

class ServerController extends Controller
{
    /**
     * ServerController constructor.
     */
    public function __construct()
    {
        Gateway::$registerAddress = '127.0.0.1:1238';
    }

    /**
     * 将聊天用户加入组内
     *
     * @param Request $request
     */
    public function joinGroup(Request $request)
    {
        $client_id = $request->input('client_id');
        $group_id  = $request->input('group_id');

        Gateway::setSession($client_id, ['group_id' => $group_id]);
        //将用户加入组内
        Gateway::joinGroup($client_id, $group_id);
    }

    /**
     * 消息入库并推送到客户端
     *
     * @param StoreChatMessage $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function send(StoreChatMessage $request)
    {
        $chat = new ChatLog();
        //消息入库
        $result = $chat->fill($request->all())->save();

        $chat_message = [
            'message_type' => 'chatMessage',
            'data' => [
                'name'    => $request['from_name'],
                'avatar'  => $request['from_avatar'],
                'id'      => $request['from_id'],
                'time'    => date('Y-m-d H:i:s'),
                'content' => $request['content'],
                'message_id' => $chat->id,
                'content_type'=> $request['content_type'],
            ]
        ];
        //将消息内容推送给接收方
        Gateway::sendToGroup($request['group_id'], json_encode($chat_message), [$request['client_id']]);

        return response()->json($result);
    }
}
