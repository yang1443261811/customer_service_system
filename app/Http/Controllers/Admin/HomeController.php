<?php

namespace App\Http\Controllers\Admin;

use App\Dialog;
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
        $total = Dialog::count();
        //今日客诉
        $todayCount = Dialog::whereDate('created_at', date('Y-m-d'))->count();
        //未处理的客诉
        $waitCount = Dialog::where('status', 1)->count();
        //当日正在处理的客诉
        $processingCount = Dialog::whereDate('created_at', date('Y-m-d'))->where('status', 2)->count();

        $data = compact('total', 'todayCount', 'waitCount', 'processingCount');

        return view('home', $data);
    }

    /**
     * Enter dialog window
     *
     * @return mixed
     */
    public function chat()
    {
        return view('chatRoom');
    }
}
