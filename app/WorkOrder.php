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
    public static function get_client_msg_count($uid)
    {
        return static::where(['uid' => $uid, 'status' => 2])->value('client_msg_unread_count');
    }

    /**
     * 设置客服未读消息
     *
     * @param int $id 工单的ID
     * @param string $type 设置的类型
     * @return mixed
     */
    public static function set_service_msg_count($id, $type)
    {
        switch ($type) {
            case 'up':
                return static::where('id', $id)->increment('server_msg_unread_count', 1);
            case 'down':
                return static::where('id', $id)->decrement('server_msg_unread_count', 1);
            case 'clear':
                return static::where('id', $id)->update(['server_msg_unread_count' => 0]);
            default:
                //nothing to do
                return null;
        }
    }

    /**
     * 设置客户未读消息
     *
     * @param int $id 工单的ID
     * @param string $type 设置的类型
     * @return mixed
     */
    public static function set_client_msg_count($id, $type)
    {
        switch ($type) {
            case 'up':
                return static::where('id', $id)->increment('client_msg_unread_count', 1);
            case 'down':
                return static::where('id', $id)->decrement('client_msg_unread_count', 1);
            case 'clear':
                return static::where('id', $id)->update(['client_msg_unread_count' => 0]);
            default:
                //nothing to do
                return null;
        }
    }

}
