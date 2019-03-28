<?php

namespace App\Http\Controllers\Admin;

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
//        echo $this->getLocation('169.235.24.133');
//        echo $this->getLocation('112.86.106.140');
//        echo $this->getLocation('127.0.0.1');
//        die;
        return view('home');
    }

    public function chat()
    {
        return view('chatRoom');
    }

    /**
     * 获取 IP  地理位置
     * 淘宝IP接口
     * @param string $ip
     * @return string
     */
    public function getLocation($ip)
    {
        $info = (new \Ip2Region())->btreeSearch($ip);

        $city = explode('|', $info['region']);
        if (0 == $info['city_id']) {
            if ($city['0'] == '0') {
                return '未知地址';
            }

            return $city['0'] . '，' . $city['2'];
        }

        return sprintf('%s%s', $city['2'], $city['3']);
    }

}
