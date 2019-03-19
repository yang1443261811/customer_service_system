<?php

namespace App\Http\Controllers;

use Validator;
use App\ChatLog;
use App\Customer;
use App\WorkOrder;
use Identicon\Identicon;
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
            'uid' => 'required|max:255',
            'name' => 'required',
        ]);

        $validator->fails() && exit($validator->errors()->first());

        //获取未读消息数
        $unread = WorkOrder::getUnreadMsgCount($request->uid);

        $output = [
            'uid'    => $request->uid,
            'name'   => $request->name,
            'unread' => $unread,
            'avatar' => $request->has('avatar')
                ? $request->avatar
                : (new Identicon())->getImageDataUri($request->uid, 256),
        ];

        return view('index', $output);
    }
}
