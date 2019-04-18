<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DialogLog extends Model
{
    /**
     * table name
     *
     * @var string
     */
    protected $table = 'cs_dialog_log';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'chat_id', 'from_id', 'from_name', 'from_avatar', 'content', 'type'
    ];

    /**
     * 获取某个人的最后回复内容
     *
     * @param int $chat_id
     * @return array
     */
    public static function getLastReply($chat_id)
    {
        return static::where('chat_id', $chat_id)
                     ->orderBy('created_at', 'desc')
                     ->first(['content', 'content_type'])
                     ->toArray();
    }

    /**
     * 有新消息加入时变更工单的最后回复消息
     *
     * @param int $chat_id 工单的ID
     * @return mixed
     */
    public static function resetLatestMessage($chat_id)
    {
        return static::where('chat_id', $chat_id)->update(['is_latest' => 0]);
    }

    /**
     * 保存一条新消息到数据库
     *
     * @param array $data
     * @return mixed
     */
    public static function insertMessage(array $data)
    {
        //有新消息加入时变更工单的最后回复消息
        static::where('chat_id', $data['chat_id'])->update(['is_latest' => 0]);

        return (new static)->fill($data)->save();
    }
}
