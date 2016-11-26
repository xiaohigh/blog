<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class InsertTagRequest extends Request
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
            'name'=>'required|unique:tags',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '标签名不能为空',
            'name.unique' => '标签名已经存在'
        ];
    }
}
