<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreChatMessage extends FormRequest
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
            'from_id' => 'required',
            'from_name' => 'required',
            'from_avatar' => 'required',
            'content' => 'required',
            'content_type' => 'required|in:1,2,3'
        ];
    }
}
