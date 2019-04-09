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
        $column = ['id', 'uid', 'name', 'avatar', 'address', 'server_msg_unread_count'];
        $data = WorkOrder::select($column)->where('kf_id', \Auth::id())->whereIn('status', [1, 2])->get();
        //获取工单的最后一句对话
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
        //获取工单的最后一句对话
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
            'uid' => 'required|max:255', 'name' => 'required', 'avatar' => 'required'
        ]);

        $workOrder = new WorkOrder();

        $input = $request->all();
        $input['address'] = $this->getCity($request->ip());        //根据ip获取地理位置
        $result = $workOrder->fill($input)->save();

        $response = $result ? ['success' => true, 'wo_id' => $workOrder->id] : ['success' => false];

        return response()->json($response);
    }

    /**
     * 工单处理完成
     *
     * @param int $id 工单的ID
     * @return \Illuminate\Http\JsonResponse
     */
    public function completed($id)
    {
        $result = WorkOrder::where('id', $id)->update(['status' => 3]);

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
