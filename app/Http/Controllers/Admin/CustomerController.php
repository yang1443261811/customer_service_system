<?php

namespace App\Http\Controllers\Admin;

use App\Customer;
use App\ChatLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CustomerController extends Controller
{
    public function lists()
    {
        $data = Customer::all()->toArray();
        foreach ($data as &$item) {
            $item['unread'] = ChatLog::where(['from_id' => $item['uid'], 'is_read' => 0])->count();
        }

        return response()->json($data);
    }
}
