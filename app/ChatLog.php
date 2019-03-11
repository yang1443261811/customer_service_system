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
        'from_id', 'from_name', 'from_avatar', 'to_id', 'to_name', 'content', 'content_type'
    ];
}
