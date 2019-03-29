<?php

namespace App\Http\Controllers;

use App\ChatLog;
use App\WorkOrder;
use Illuminate\Http\Request;

class WorkOrderController extends Controller
{
    /**
     * 获取当前用户的工单
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function myself()
    {
        $data = WorkOrder::where('kf_id', \Auth::id())->get();
        foreach ($data as &$item) {
            $item['lastReply'] = ChatLog::getLastReply($item['id']);
        }

        return response()->json($data);
    }

    /**
     * 获取新工单(状态为1的工单就是新工单)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getNew()
    {
        $data = WorkOrder::where('status', 1)->get();
        foreach ($data as &$item) {
            $item['lastReply'] = ChatLog::getLastReply($item['id']);
        }

        return response()->json($data);
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
            'uid'    => 'required|max:255',
            'name'   => 'required',
            'avatar' => 'required',
        ]);

        $workOrder = new WorkOrder();

        $input = $request->all();
        //根据ip获取地理位置
        $input['address'] = $this->getCity($request->ip());
        $result = $workOrder->fill($input)->save();

        $response = $result ? ['success' => true, 'wo_id' => $workOrder->id] : ['success' => false];

        return response()->json($response);
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
            return $city['2'] .','. $city['3'];
        }

        if ($city['0'] == '0') {
            return '未知地址';
        }

        return $city['0'] . '，' . $city['2'];

    }
}
