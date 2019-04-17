<?php

namespace App\Http\Controllers;

use App\ChatLog;
use App\WorkOrder;
use Illuminate\Http\Request;

class WorkOrderController extends Controller
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

        $result = WorkOrder::where($where)->orderBy('updated_at', 'desc')->paginate(13);
        //获取工单的最后一句对话
        foreach ($result as &$item) {
            $item['lastReply'] = ChatLog::getLastReply($item['id']);
        }

        return response()->json($result);
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

        $result = $workOrder->fill($input)->save()
            ? ['success' => true, 'wo_id' => $workOrder->id]
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
        $result = WorkOrder::setStatus($id, 3);

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
