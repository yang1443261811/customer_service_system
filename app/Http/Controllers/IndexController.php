<?php

namespace App\Http\Controllers;

use Validator;
use App\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    /**
     * 首页
     *
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'uid'    => 'required|max:255',
            'avatar' => 'required',
            'name'   => 'required',
        ]);

        $validator->fails() && exit($validator->errors()->first());

        $where = array('uid' => $request->uid);
        $input = array(
            'uid'    => $request->uid,
            'name'   => $request->name,
            'avatar' => $request->avatar,
        );

        $data = Customer::firstOrCreate($where, $input);

        return view('index', $request->all());
    }
}
