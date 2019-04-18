<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Dialog extends Model
{
    /**
     * table name
     *
     * @var string
     */
    protected $table = 'cs_dialog';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'uid', 'avatar', 'kf_id', 'status', 'address', 'customer_unread', 'kf_unread'
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
    public static function set_kf_unread($id, $type)
    {
        switch ($type) {
            case 'up':
                return static::where('id', $id)->increment('kf_unread', 1);
            case 'down':
                return static::where('id', $id)->decrement('kf_unread', 1);
            case 'clear':
                return static::where('id', $id)->update(['kf_unread' => 0]);
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
    public static function set_customer_unread($id, $type)
    {
        switch ($type) {
            case 'up':
                return static::where('id', $id)->increment('customer_unread', 1);
            case 'down':
                return static::where('id', $id)->decrement('customer_unread', 1);
            case 'clear':
                return static::where('id', $id)->update(['customer_unread' => 0]);
            default:
                //nothing to do
                return null;
        }
    }

    /**
     * 分页获取会话列表,并获得会话的最后回复消息
     *
     * @param array $where
     * @param int $number
     * @param string $sort
     * @param string $sortColumn
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function pageWithRequest(array $where, $number = 20, $sort = 'desc', $sortColumn = 'updated_at')
    {
        return DB::table('cs_dialog as A')
                 ->select('A.*', 'B.content', 'B.type')
                 ->leftJoin('cs_dialog_log as B', function ($join) {
                    $join->on('A.id', '=', 'B.chat_id')
                        ->where('B.is_latest', '=', 1);
                 })
                 ->where($where)
                 ->orderBy($sortColumn, $sort)
                 ->paginate($number);
    }
}
