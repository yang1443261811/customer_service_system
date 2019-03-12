<?php

namespace App\Http\Controllers;

use App\ChatLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ChatLogController extends Controller
{
    /**
     * 根据uid获取聊天记录
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function get(Request $request)
    {
        $uid = $request->input('uid');
        //请求来源于普通用户还是客服人员,from = kf 表示请求来源于客服人员否则就是普通用户的请求
        $from = $request->input('from');

        //如果请求来源于普通用户则将客服发给用户的所有未读消息更新为已读
        //如果请求来源于客服人员那么将用户发给客服人员的所有未读消息更新为已读
        $where = $from == 'kf' ? ['from_id' => $uid] : ['to_id' => $uid];
        ChatLog::where($where)->update(['is_read' => 1]);

        $data = ChatLog::where(function ($query) use ($uid) {
            $query->where('from_id', $uid)->orWhere('to_id', $uid);
        })->orderBy('created_at', 'asc')->get();

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
     * 更新消息为已读
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function haveRead($id)
    {
        $result = ChatLog::where('id', $id)->update(['is_read' => 1]);

        return response()->json($result);
    }
}
