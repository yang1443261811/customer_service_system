<?php

namespace App\Http\Controllers\Admin;

use App\Dialog;
use App\DialogLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChatRecordController extends Controller
{
    /**
     * 服务端根据工单ID获取聊天记录
     *
     * @param int $chat_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function get($chat_id)
    {
        //将工单里用户发送给客服的未读消息数清零
        Dialog::set_kf_unread($chat_id, 'clear');

        $result = DialogLog::where('chat_id', $chat_id)
            ->orderBy('created_at', 'desc')
            ->paginate(20)
            ->toArray();

        //反转聊天记录的顺序,使其在展示时是正序排列的
        $result['data'] = array_reverse($result['data']);

        return response()->json($result);
    }

    /**
     * 更新客户消息为已读
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function haveRead($id)
    {
        $result = Dialog::set_customer_unread($id, 'down');

        return response()->json($result);
    }
}
