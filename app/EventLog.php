<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class EventLog extends Model
{
    /**
     * table name
     *
     * @var string
     */
    protected $table = 'event_log_base';

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

    /**
     * Get the page of articles without draft scope.
     *
     * @param  Request $request
     * @param  integer $number
     * @param  string $sort
     * @param  string $sortColumn
     * @return mixed
     */
    public static function pageWithRequest2($request, $number = 15, $sort = 'desc', $sortColumn = 'id')
    {
        $keyword = $request->get('keyword');
        return static::when($keyword, function ($query) use ($keyword) {
            $query->where('event_name', $keyword);
//            $query->where('event_name', 'like', "%{$keyword}%");
//                ->orWhere('media_source', 'like', "%{$keyword}%");
        })
            ->orderBy($sortColumn, $sort)->paginate($number);
    }

    public static function pageWithRequest($request, $number = 15, $sort = 'desc', $sortColumn = 'id')
    {
        $page = $request->get('page', 1);
        $keyword = $request->get('keyword');
        if ($keyword) {

        } else {

        }

        $smallest_id = 43615;
        $start = $smallest_id + ($page - 1) * $number;
        $data = static::where('id', '>=', $start)->limit($number)->get();

        return $data;
    }

    public static function getPageNav($route, $page)
    {
        $limit = 15;
        $total = 11149580;
        $last_page = floor($total / $limit);
        $i = 0;
        $map = array();
        while ($i < 5) {
            $i++;
            $num = ($page - 3 >= 0) ? ($page - 3) + $i : $i;
            if ($num <= $last_page) {
                $map[] = $num;
            } else {
                break;
            }
        }

        if ($last_page - 2 > $map[count($map) - 1]) {
            array_push($map, ...['...', $last_page - 1, $last_page]);
        }

        if ($map[1] - 2 > 0) {
            array_unshift($map, ...[1, 2, '...']);
        }

        $link = '<ul class="pagination" role="navigation">';
        foreach ($map as $val) {
            if ($val == '...') {
                $link .= '<li class="page-item disabled" aria-disabled="true"><span class="page-link">...</span></li>';
            } elseif ($val == $page) {
                $link .= '<li class="active"><span>' . $val . '</span></li>';
            } else {
                $link .= sprintf('<li class="page-item"><a class="page-link" href="%s?page=%s">%s</a></li>', $route, $val, $val);
            }
        }

        return $link . '</ul>';
    }

    public static function getMedia()
    {
        if ($media_list = Redis::get('media_list')) {
            return json_decode($media_list, true);
        }

        $media_list = DB::table('media')->pluck('name', 'id');
        Redis::set('media_list', $media_list->toJson());

        return $media_list->toArray();

    }

    public static function getEvents()
    {
        if ($events = Redis::get('events')) {
            return json_decode($events, true);
        }

        $events = DB::table('events')->pluck('name', 'id');
        Redis::set('events', $events->toJson());

        return $events->toArray();
    }

}
