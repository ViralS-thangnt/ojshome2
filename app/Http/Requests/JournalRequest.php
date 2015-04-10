<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class JournalRequest extends Request
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
            'name'              =>  'required|min:2',
            'num'               =>  'required|numeric',
            'publish_at'        =>  'required',
            'cover'             =>  'image'
        ];
    }

    public function messages()
    {
        return [
            'name.required'             => trans('admin.journal.name.required'),
            'name.min'                  => trans('admin.journal.name.min'),
            'num.required'              => trans('admin.journal.num.required'),
            'num.numeric'               => trans('admin.journal.num.numeric'),
            'publish_at.required'       => trans('admin.journal.publish_at.required'),
            'cover.image'               => trans('admin.journal.cover.image')
        ];
    }
}
