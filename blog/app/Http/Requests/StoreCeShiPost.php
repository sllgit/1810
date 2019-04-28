<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCeShiPost extends FormRequest
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
        $id=request()->id;
        return [
            'name'=>[
                'required',
                'unique:ceshi,name,'.$id,
         function($attribute, $value, $fail) {
             $reg = '/^[a-zA-Z0-9_(\x{4e00}-\x{9fa5})]{1,}$/u';
             if (!preg_match($reg,$value)) {
                 return $fail('名称为中文数字字母下划线组成');
             }
         },
                ],
            'url'=>[
                'required',
                function($attribute, $value, $fail) {
                        $reg='/^http(\:)(\/)(\/)(w){3}(\.)[a-zA-Z]{1,}(\.)(com)$/';
                            if (!preg_match($reg,$value)) {
                                return $fail('网站网址必须以http开头');
                        }
                    },
                ],
            'people'=>'required',
            'content'=>'required',
        ];
    }
    public function messages()
    {
        return [
            'name.required'=>'姓名必填',
            'name.unique'=>'该名称已存在',
            'url.required'=>'网址必填',
            'people.required'=>'联系人必填',
            'content.required'=>'介绍必填',
        ];
    }
}
