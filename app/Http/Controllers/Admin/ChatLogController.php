<?php

namespace App\Http\Controllers\Admin;

use App\ChatLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChatLogController extends Controller
{
    public function get($uid)
    {
        $data = ChatLog::where(function ($query) use ($uid) {
            $query->where('from_id', $uid)->orWhere('to_id', $uid);
        })->orderBy('created_at', 'asc')->get();

        return response()->json($data);
    }
}
