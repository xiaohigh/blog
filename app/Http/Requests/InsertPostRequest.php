<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class InsertPostRequest extends Request
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
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|same:repassword|regex:/^\w{6,10}$/',
        ];
    }

    /**
     * 用来设定错误的报错信息
     */
    public function messages()
    {
        return [
            'name.required' => '用户名不能省略',
            'email.required' => '邮箱不能省略',
            'email.email' => '格式必须是邮箱',
            'password.regex'=>'密码必须为6~10位字母数字下划线',
            'password.max'=>'不能超过10位',
            'password.min'=>'不能小于6位',
            'password.required'=>'密码必须填写',
            'password.same' => '两次密码必须一致'
        ];
    }
}
