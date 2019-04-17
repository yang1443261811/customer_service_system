<?php

namespace App\Http\Controllers\Admin;

use App\WorkOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //累计客诉
        $total = WorkOrder::count();
        //今日客诉
        $todayCount = WorkOrder::whereDate('created_at', date('Y-m-d'))->count();
        //未处理的客诉
        $waitCount = WorkOrder::where('status', 1)->count();
        //当日正在处理的客诉
        $processingCount = WorkOrder::whereDate('created_at', date('Y-m-d'))->where('status', 2)->count();

        $data = compact('total', 'todayCount', 'waitCount', 'processingCount');

        return view('home', $data);
    }

    public function chat()
    {
        return view('chatRoom');
    }
}
