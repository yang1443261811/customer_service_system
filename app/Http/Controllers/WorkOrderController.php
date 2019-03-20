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

        return response()->json($data);
    }

    /**
     * 获取用户未处理完成的历史工单
     *
     * @param $uid
     * @return \Illuminate\Http\JsonResponse
     */
    public function getByUid($uid)
    {
        $history = WorkOrder::where('uid', $uid)->whereIn('status', [1, 2])->first();
        if ($history) {
            $chatRecord = ChatLog::where('wo_id', $history->id)->get()->toArray();

            return response()->json(['wo_id' => $history->id, 'chatRecord' => $chatRecord]);
        }

        return response()->json(['wo_id' => '', 'chatRecord' => []]);
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

}
