<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class KeywordRequest extends Request
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
            'lang_code'          =>  'required',
            'text'               =>  'required|unique:keywords',
        ];
    }

    public function messages()
    {
        return [
            'lang_code.required'     => trans('admin.keyword.lang_code.required'),
            'text.required'          => trans('admin.keyword.text.required'),
            
        ];
    }
}


