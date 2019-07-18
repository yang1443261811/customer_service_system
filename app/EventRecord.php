<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventRecord extends Model
{
    /**
     * table name
     *
     * @var string
     */
    protected $table = 'event_log';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'app_id',
        'event_name',
        'event_time',
        'event_value',
        'media_source',
        'install_time',
        'advertising_id',
    ];

//    /**
//     * Get the created at attribute.
//     *
//     * @param $value
//     * @return string
//     */
//    public function getEventNameAttribute($value)
//    {
//        return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $value)->diffForHumans();
//    }
//
//    /**
//     * Get the created at attribute.
//     *
//     * @param $value
//     * @return string
//     */
//    public function getMediaSourceAttribute($value)
//    {
//        return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $value)->diffForHumans();
//    }

}
