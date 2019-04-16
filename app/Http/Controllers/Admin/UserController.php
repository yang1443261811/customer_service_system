<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateUser;
use App\Http\Requests\StoreUser;
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

    /**
     * 删除用户
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {
//        return response()->json(User::destroy($id));
        return response()->json(true);
    }

    /**
     * 创建新用户
     *
     * @param StoreUser $request
     * @return mixed
     */
    public function store(StoreUser $request)
    {
        $input = $request->only('name', 'email', 'password');
        $input['password'] = bcrypt($request['password']);

        $user = new User($input);

        $result = $user->save()
            ? ['success' => true, 'id' => $user->id, 'created_at' => date('Y-m-d H:i:s')]
            : ['success' => false];

        return response()->json($result);
    }
}
