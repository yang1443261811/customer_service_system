<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChatLog extends Model
{
    /**
     * table name
     *
     * @var string
     */
    protected $table = 'cs_chat_log';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'wo_id', 'from_id', 'from_name', 'from_avatar', 'to_id', 'to_name', 'content', 'content_type'
    ];

    /**
     * 保存聊天消息
     *
     * @param array $data
     * @return bool
     */
    public function insertChatLog(array $data)
    {
        $workOrder = new WorkOrder();
        //如果用户有未处理完成的工单,把工单号查询出来,一起保存到消息记录表中,形成工单表与消息记录表的关联关系
        //如果没有就新建一条工单使工单与消息关联
        $data['wo_id'] = $workOrder->where(['uid' => $data['uid'], 'status' => 2])->value('id');
        if (!$data['wo_id']) {
            $workOrder->fill($data)->save();

            $data['wo_id'] = $workOrder->id;
        }

        return (new ChatLog)->fill($data)->save();

    }
}
