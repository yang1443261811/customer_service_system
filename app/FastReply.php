<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FastReply extends Model
{
    /**
     * table name
     *
     * @var string
     */
    protected $table = 'cs_fast_reply';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'word', 'uid'];


}
