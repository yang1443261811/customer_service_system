<?php

namespace App\Http\Controllers;

use Validator;
use App\ChatLog;
use App\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    /**
     * 首页
     *
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'uid'    => 'required|max:255',
            'avatar' => 'required',
            'name'   => 'required',
        ]);

        $validator->fails() && exit($validator->errors()->first());

        Customer::firstOrCreate(['uid' => $request->uid], [
            'uid'    => $request->uid,
            'name'   => $request->name,
            'avatar' => $request->avatar,
        ]);

        //获取用户未读消息数量
        $unread = ChatLog::where(['to_id' => $request->uid, 'is_read' => 0])->count();

        return view('index', $request->all())->with('unread', $unread);
    }
}
