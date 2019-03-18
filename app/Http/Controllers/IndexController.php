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
//            'avatar' => 'required',
        ]);

        $validator->fails() && exit($validator->errors()->first());

        //获取用户未读消息数量
        $unread = ChatLog::where(['to_id' => $request->uid, 'is_read' => 0])->count();

        $workOrder = new WorkOrder();

        //如果用户有未处理完成的工单那么直接进入该工单,如果没有就创建一个新的工单
        $result = $workOrder->where('from_id', $request->uid)->whereIn('status', [1, 2])->first();
        if ($result) {
            return view('index', $result)->with('unread', $unread);
        } else {
            $data = array(
                'from_id' => $request->uid,
                'from_name' => $request->name,
                'from_avatar' => (new Identicon())->getImageDataUri($request->uid, 256),
            );
            $workOrder->fill($data)->save();

            return view('index', $data)->with('unread', $unread)->with('id', $workOrder->id);
        }
    }
}
