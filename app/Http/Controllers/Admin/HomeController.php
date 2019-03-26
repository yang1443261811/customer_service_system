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
//        $siteInfo = $this->getLocation('153.34.211.166');
//        print_r($siteInfo);
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
     * @return array
     */
    public function getLocation($ip)
    {
        $obj = curl_init();
        //设置抓取的网页地址
        curl_setopt($obj, CURLOPT_URL, "http://ip.taobao.com/service/getIpInfo.php?ip=" . $ip);
        //设置不直接打印网页内容
        curl_setopt($obj, CURLOPT_RETURNTRANSFER, true);
        //执行
        $result = curl_exec($obj);
        $location = json_decode($result, true);
        //关闭资源
        curl_close($obj);

        return $location;
    }

}
