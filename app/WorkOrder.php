<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkOrder extends Model
{
    /**
     * table name
     *
     * @var string
     */
    protected $table = 'cs_work_order';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'from_name', 'from_id', 'from_avatar', 'content', 'content_type', 'kf_id', 'status', 'client_msg_unread_count', 'server_msg_unread_count'
    ];

    /**
     * 根据工单id判断工单是否是新工单(状态为1的工单)
     *
     * @param int $id
     * @return bool
     */
    public static function isNew($id)
    {
        $status = static::where('id', $id)->value('status');

        return $status == 1;
    }

    /**
     * 获取工单的状态
     *
     * @param int $id
     * @return mixed
     */
    public static function getStatus($id)
    {
        return static::where('id', $id)->value('status');
    }

    /**
     * 设置工单的状态
     *
     * @param int $id
     * @param int $status
     * @return mixed
     */
    public static function setStatus($id, $status)
    {
        return static::where('id', $id)->update(['status' => $status, 'kf_id' => \Auth::id()]);
    }

    /**
     * 获取用户未读消息数
     *
     * @param $uid
     * @return mixed
     */
    public static function getUnreadMsgCount($uid)
    {
        return static::where(['uid' => $uid, 'status' => 2])->value('client_msg_unread_count');
    }

    /**
     * 客服发送的消息已读
     *
     * @param int $id 工单ID
     */
    public static function setServerUnreadCount($id)
    {
        return static::where('id', $id)->decrement('server_msg_unread_count', 1);
    }

    /**
     * 用户发送的消息已读
     *
     * @param int $id 工单ID
     */
    public static function setClientUnreadCount($id)
    {
        return static::where('id', $id)->decrement('client_msg_unread_count', 1);
    }
}
