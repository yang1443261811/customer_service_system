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
    public function get($uid)
    {
        $data = WorkOrder::where('uid', $uid)->whereIn('status', [1, 2])->first();
        if ($data) {
            //将工单里客服发送给用户的未读消息数清零
            WorkOrder::set_client_msg_count($data->id, 'clear');

            $chatRecord = ChatLog::where('wo_id', $data->id)->get()->toArray();

            return response()->json(['wo_id' => $data->id, 'kf_id' => $data->kf_id, 'chatRecord' => $chatRecord]);
        }

        return response()->json(['wo_id' => '', 'kf_id' => '', 'chatRecord' => []]);
    }

    /**
     * 更新客户消息为已读
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function haveRead($id)
    {
        $result = WorkOrder::set_client_msg_count($id, 'down');;

        return response()->json($result);
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
}
