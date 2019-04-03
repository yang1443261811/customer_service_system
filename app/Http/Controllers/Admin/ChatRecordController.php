<?php

namespace App\Http\Controllers\Admin;

use App\ChatLog;
use App\WorkOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChatRecordController extends Controller
{
    /**
     * 服务端根据工单ID获取聊天记录
     *
     * @param int $wo_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function get($wo_id)
    {
        //将工单里用户发送给客服的未读消息数清零
        WorkOrder::where('id', $wo_id)->update(['server_msg_unread_count' => 0]);

        $result = ChatLog::where('wo_id', $wo_id)->orderBy('created_at', 'desc')->paginate(20)->toArray();
//        print_r($data->toArray());die;
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
        $result = WorkOrder::where('id', $id)->decrement('server_msg_unread_count', 1);

        return response()->json($result);
    }
}
