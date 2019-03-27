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
            'uid' => 'required|max:255',
            'name' => 'required',
            'avatar' => 'required',
        ]);

        $workOrder = new WorkOrder();
        $result = $workOrder->fill($request->all())->save();

        $response = $result ? ['success' => true, 'wo_id' => $workOrder->id] : ['success' => false];

        return response()->json($response);
    }

    /**
     * ip定位
     *
     * @param Request $request
     * @return \think\response\Json
     */
    public function getCity(Request $request)
    {
        $info = (new \Ip2Region())->btreeSearch($request->ip());

        $city = explode('|', $info['region']);

        if (0 != $info['city_id']) {
            return response()->json(['data' => $city['2'] . $city['3'] . $city['4'], 'msg' => 'ok']);
        } else {

            return response()->json(['data' => $city['0'], 'msg' => 'ok']);
        }
    }
}
