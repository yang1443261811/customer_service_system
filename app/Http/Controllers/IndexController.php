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
            'uid'    => 'required|max:255',
            'name'   => 'required',
//            'avatar' => 'required',
        ]);

        $validator->fails() && exit($validator->errors()->first());

        $data = array(
            'from_id'     => $request->uid,
            'from_name'   => $request->name,
            'from_avatar' => (new Identicon())->getImageDataUri($request->uid, 256),
        );

        $result = WorkOrder::firstOrCreate(['from_id' => $request->uid, 'status' => 2], $data);

        //获取用户未读消息数量
        $unread = ChatLog::where(['to_id' => $request->uid, 'is_read' => 0])->count();

        return view('index', $result)->with('unread', $unread);
    }
}
