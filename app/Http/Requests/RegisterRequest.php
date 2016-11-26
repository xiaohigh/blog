<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Contracts\Validation\Validator;

class RegisterRequest extends Request
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
            //
            'name'=>'required|unique:users',
            'email'=>'required|unique:users|email',
            'password'=>'required|regex:/^\S{6,18}$/',
            'repassword'=>'same:password'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '昵称不能为空',
            'name.unique' => '昵称已经存在',
            'email.required' => '邮箱不能为空',
            'email.unique'=>'邮箱已经存在',
            'email.email'=>'邮箱格式不正确',
            'password.required'=>'密码不能为空',
            'password.regex' => '密码必须为6到18位的非空白字符',
            'repassword.same'=> '两次密码不一致'
        ];
    }

    
}
