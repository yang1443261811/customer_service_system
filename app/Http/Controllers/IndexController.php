<?php

namespace App\Http\Controllers;

use Validator;
use App\DialogLog;
use App\Customer;
use App\Dialog;
use Identicon\Identicon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use EasyWeChat\Factory;

class IndexController extends Controller
{
    public function demo()
    {
        $options = [
            'app_id' => 'wx3cf0f39249eb0exxx',
            'secret' => 'f1c242f4f28f735d4687abb469072xxx',
            'token'  => 'easywechat',
            'log'    => [
                'level' => 'debug',
                'file'  => '/tmp/easywechat.log',
            ],
            // ...
        ];
        $app = Factory::officialAccount($options);
        echo 123;die;

        $server = $app->server;
        $user = $app->user;

        $server->push(function ($message) use ($user) {
            $fromUser = $user->get($message['FromUserName']);

            return "{$fromUser->nickname} 您好！欢迎关注 overtrue!";
        });

        $server->serve()->send();
    }

    /**
     * 首页
     *
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'uid'  => 'required|max:255',
            'name' => 'required',
        ]);

        $validator->fails() && exit($validator->errors()->first());
        //获取未读消息数
        $unread = Dialog::get_client_msg_count($request->uid);
        //如果没有传递头像就自动生成头像
        $avatar = $request->avatar ?: (new Identicon())->getImageDataUri($request->uid, 256);

        return view('index', [
            'unread' => $unread,
            'avatar' => $avatar,
            'uid'    => $request->uid,
            'name'   => $request->name,
        ]);
    }
}
