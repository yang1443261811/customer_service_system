<?php

namespace App\Http\Controllers\Admin;

use App\EventLog;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventLogController extends Controller
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function event_log_base(Request $request)
    {
        $page = $request->input('page', 1);
        $media = array_filter(EventLog::getMedia());
        $events = EventLog::getEvents();
        $data = EventLog::pageWithRequest($request);
        $links = EventLog::getPageNav('/eventLog/event_log_base', $page);

        $output = compact('media', 'events', 'links', 'data');

        return view('event/eventLogBase', $output);
    }

    public function event_log(Request $request)
    {
        DB::select("CREATE TABLE log_2 SELECT * FROM event_log WHERE 1=2");
        die;
        $media = $request->get('media');
        $keyword = $request->get('keyword');
        $event_name = $request->get('event_name');

        $query = DB::table('event_log');
        if ($keyword) {
            $query->where('advertising_id', $keyword);
        }

        if ($media) {
            $query->where('media_source', $media);
        }

        if ($event_name) {
            $query->where('event_name', $event_name);
        }

        $data = $query->paginate(15);
        $media_list = array_filter(EventLog::getMedia());
        $events = EventLog::getEvents();

        foreach ($data as $item) {
            $item->event_name = $events[$item->event_name];
            $item->media_source = $media_list[$item->media_source];
        }

        return view('event/eventLog', compact('media_list', 'events', 'links', 'data', 'media', 'keyword', 'event_name'));
    }
}
