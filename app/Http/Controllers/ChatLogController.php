<?php

namespace App\Http\Controllers;

use App\ChatLog;
use App\WorkOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ChatLogController extends Controller
{
    /**
     * 客户端根据用户ID获取聊天记录
     *
     * @param int $uid
     * @return \Illuminate\Http\JsonResponse
     */
    public function getByClient($uid)
    {
        $data = WorkOrder::where('uid', $uid)->whereIn('status', [1, 2])->first();

        if ($data) {
            //获取聊天记录
            $chatRecord = ChatLog::where('wo_id', $data->id)->get()->toArray();
            //将工单里客服发送给用户的未读消息数清零
            WorkOrder::where('id', $data->id)->update(['client_msg_unread_count' => 0]);

            return response()->json(['wo_id' => $data->id, 'chatRecord' => $chatRecord]);
        }

        return response()->json(['wo_id' => '', 'chatRecord' => []]);
    }

    /**
     * 服务端根据工单ID获取聊天记录
     *
     * @param int $wo_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getByServer($wo_id)
    {
        //将工单里用户发送给客服的未读消息数清零
        WorkOrder::where('id', $wo_id)->update(['server_msg_unread_count' => 0]);

        $data = ChatLog::where('wo_id', $wo_id)->orderBy('created_at', 'asc')->get();

        return response()->json($data);
    }

    /**
     * 上传图片
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function upload(Request $request)
    {
        $this->validate($request, ['image' => 'required|image|file']);

        $path = $request->file('image')->store('avatars', 'public');

        return response()->json(['url' => Storage::url($path)]);
    }

    /**
     * 更新客户消息为已读
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function clientHaveRead($id)
    {
        $result = WorkOrder::where('id', $id)->decrement('client_msg_unread_count', 1);

        return response()->json($result);
    }

    /**
     * 更新客户消息为已读
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function serverHaveRead($id)
    {
        $result = WorkOrder::where('id', $id)->decrement('server_msg_unread_count', 1);

        return response()->json($result);
    }
}
