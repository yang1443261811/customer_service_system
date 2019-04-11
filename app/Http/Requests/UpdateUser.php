<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUser extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:32',
            'email' => 'required|email'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '用户不能为空！',
            'name.max' => '用户名太长！',
            'email.required' => '电子邮箱不能为空！',
            'email.email' => '邮箱格式错误！',
        ];
    }
}
