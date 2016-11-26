<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class PermissionRequest extends Request
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
            'display_name'=>'required'
        ];
    }

    /**
     * 设定文字显示
     */
    public function messages()
    {
        return [
            'name.required' => '标识不能为空',
            'display_name.required' => '权限规则名称不能为空',
            'name.unique' => '权限规则已经存在'
        ];
    }

}
