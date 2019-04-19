<?php

namespace App\Http\Controllers;

use App\Dialog;
use App\DialogLog;
use Illuminate\Http\Request;

class DialogController extends Controller
{
    /**
     * 按条件获取工单列表并分页
     *
     * @param int $type 获取那种类型的工单
     * @return \Illuminate\Http\JsonResponse
     */
    public function get($type)
    {
        $where = $type == 1 ? ['status' => 1] : ['status' => 2, 'kf_id' => \Auth::id()];

        $result = Dialog::pageWithRequest($where);

        return response()->json($result);
    }

    /**
     * 获取会话列表
     *
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        $data = Dialog::orderBy('updated_at', 'desc')->paginate(20);

        return view('dialog.index', compact('data'));
    }

    /**
     * 会话详细信息
     *
     * @param int $id
     * @return mixed
     */
    public function details($id)
    {
        $data = Dialog::find($id);

        $data['messages'] = DialogLog::where('chat_id', $data->id)->orderBy('created_at', 'desc')->get();

        return view('dialog.details', compact('data'));
    }

    /**
     * 创建一条新的工单
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        $this->validate($request, [
            'uid' => 'required|max:255', 'name' => 'required', 'avatar' => 'required'
        ]);

        $dialog = new Dialog();

        $input = $request->all();
        $input['address'] = $this->getCity($request->ip());        //根据ip获取地理位置

        $result = $dialog->fill($input)->save()
            ? ['success' => true, 'chat_id' => $dialog->id]
            : ['success' => false];

        return response()->json($result);
    }

    /**
     * 工单处理完成
     *
     * @param int $id 工单的ID
     * @return \Illuminate\Http\JsonResponse
     */
    public function completed($id)
    {
        //设置工单状态为3(表示该工单已处理完成)
        $result = Dialog::setStatus($id, 3);

        return response()->json($result);
    }

    /**
     * ip定位
     *
     * @param string $ip
     * @return string
     */
    protected function getCity($ip)
    {
        $info = (new \Ip2Region())->btreeSearch($ip);
        $city = explode('|', $info['region']);

        if (0 != $info['city_id']) {
            return $city['2'] . ',' . $city['3'];
        }

        if ($city['0'] == '0') {
            return '未知地址';
        }

        return $city['0'] . '，' . $city['2'];
    }
}
