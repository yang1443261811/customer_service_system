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
        'name', 'uid', 'avatar', 'kf_id', 'status', 'address', 'client_msg_unread_count', 'server_msg_unread_count'
    ];

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

}
