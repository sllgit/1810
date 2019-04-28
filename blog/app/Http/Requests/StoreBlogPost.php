<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBlogPost extends FormRequest
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
            'name'=>[
                'required',
                'unique:sihao',
                'max:20',
                'min:3',
                Rule::unique('sihao')->ignore(request()->id),
            ],
            'age'=>'bail|required|integer'
        ];
    }

    public function messages()
    {
       return [
           'name.required'=>'姓名必填',
           'name.unique'=>'该名称已存在',
           'name.max'=>'姓名最大为20个字符',
           'name.min'=>'姓名最小为3个字符',
           'age.required'=>'年龄必填',
           'age.integer'=>'年龄必须为数字',
       ];
    }
}
