<?php

namespace App\Http\Controllers\Admin;

use App\FastReply;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FastReplyController extends Controller
{
    /**
     * 获取当前用户创建的快捷回复
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function get()
    {
        $data = FastReply::where('uid', \Auth()::id())->get();

        return response()->json($data);
    }

    /**
     * 新增一个快捷回复
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        $this->validate($request, [
           'title' => 'require|max:24',
            'word' => 'require'
        ]);

        $input = $request->all();
        $input['uid'] = \Auth()::id();

        $result = (new FastReply($input))->save();

        return response()->json($result);
    }

    /**
     * 删除一个快捷回复
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {
        $result = FastReply::destroy($id);

        return response()->json($result);
    }
}
