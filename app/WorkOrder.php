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
        'from_name', 'from_id', 'from_avatar', 'content', 'content_type', 'kf_id', 'status'
    ];
}
