<?php

namespace App\Http\Controllers;

use GatewayClient\Gateway;
use Illuminate\Http\Request;

class ServerController extends Controller
{
    public function __construct()
    {
        Gateway::$registerAddress = '127.0.0.1';
    }

    public function joinGroup(Request $request)
    {
        $client_id = $request->input('client_id');
        $group_id  = $request->input('group_id');

        Gateway::setSession($client_id, ['group_id' => $group_id]);
        //将用户加入组内
        Gateway::joinGroup($client_id, $group_id);

        Gateway::sendToClient($client_id, json_encode([
            'message_type' => 'init',
            'success'      => true,
            'time'         => time(),
            'data'         => 'server connect success',
        ]));

        echo 123;
//        return response()->json($list);
    }
}
