<?php

namespace App\Http\Controllers;

use App\ChatLog;
use App\WorkOrder;
use Illuminate\Http\Request;

class WorkOrderController extends Controller
{
    public function myself()
    {
        $data = WorkOrder::where('kf_id', \Auth::id())->get();

        return response()->json($data);
    }

    public function getNew()
    {
        $data = WorkOrder::where('status', 1)->get();

        return response()->json($data);
    }

    public function history($uid)
    {
        $history = WorkOrder::where(['uid' => $uid, 'status' => 2])->first();

        if ($history) {
            $chatRecord = ChatLog::where('wo_id', $history->id)->get()->toArray();
            $data = ['wo_id' => $history->id, 'chatRecord' => $chatRecord];
        } else {
            $data = ['wo_id' => '', 'chatRecord' => []];
        }

        return response()->json($data);

    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'uid'    => 'required|max:255',
            'name'   => 'required',
            'avatar' => 'required',
        ]);

        $workOrder = new WorkOrder();

        $result = $workOrder->fill($request->all())->save();

        $response = $result ? ['success' => true, 'wo_id' => $workOrder->id] : ['success' => false];

        return response()->json($response);
    }

}
