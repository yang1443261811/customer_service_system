<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateUser;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * 首页
     *
     * @return mixed
     */
    public function index()
    {
        return view('user/index', ['data' => User::all()]);
    }

    /**
     * 更新用户信息
     *
     * @param UpdateUser $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateUser $request, $id)
    {
        $input = $request->only('name', 'email');

        $result = User::where('id', $id)->update($input);

        return response()->json($result);
    }
}
