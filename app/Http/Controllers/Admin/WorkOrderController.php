<?php

namespace App\Http\Controllers\Admin;

use App\ChatLog;
use App\WorkOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WorkOrderController extends Controller
{
    public function myself()
    {
        $data = WorkOrder::where('kf_id', \Auth::id())->get()->toArray();

        foreach ($data as &$item) {
            $item['unread'] = ChatLog::where(['wo_id' => $item['id'], 'is_read' => 0])->count();
        }

        return response()->json($data);
    }

    public function getNew()
    {
        $data = WorkOrder::where('status', 1)->get()->toArray();

        foreach ($data as &$item) {
            $item['unread'] = ChatLog::where(['wo_id' => $item['id'], 'is_read' => 0])->count();
        }

        return response()->json($data);
    }

}
