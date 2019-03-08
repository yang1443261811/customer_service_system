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
     * @param string $uid
     * @return \Illuminate\Http\JsonResponse
     */
    public function get($uid)
    {
        $data = ChatLog::where(function ($query) use ($uid) {
            $query->where('from_id', $uid)->orWhere('to_id', $uid);
        })->orderBy('created_at', 'asc')->get();

        return response()->json($data);
    }

    public function upload(Request $request)
    {
        $this->validate($request, ['image' => 'required|image|file']);

        $path = $request->file('image')->store('avatars', 'public');

        return response()->json(Storage::url($path));
    }
}
