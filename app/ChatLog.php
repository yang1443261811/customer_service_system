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
     * 获取某个人的最后回复内容
     *
     * @param int $wo_id
     * @return mixed
     */
    public static function getLastReply($wo_id)
    {
        return static::select('content', 'content_type')
                     ->where('wo_id', $wo_id)
                     ->orderBy('created_at', 'desc')
                     ->first()
                     ->toArray();

    }
}
