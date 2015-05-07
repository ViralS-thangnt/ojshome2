<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use Input;

class UserRequest extends Request
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
        // dd(Input::all());
        $actor = (empty(Input::get('actor_no')) ? null : implode(Input::get('actor_no'), ","));
        Input::merge(['actor_no' => $actor]);
        $symbol_collection_allow = '-_,:\/.;';
        $character_collection = '[\pL\s\d';

        return [
            'username'          =>  'required|max:40|regex:/^[\pL\s\d-_]+$/u',
            'password'          =>  'required|min:8|max:32|confirmed',
            'last_name'         =>  'required|max:40|regex:/^[\pL\s\d-_]+$/u',
            'first_name'        =>  'required|max:40|regex:/^[\pL\s\d-_]+$/u',
            'middle_name'       =>  'regex:/^[\pL\s\d-_]+$/u',
            'year'              =>  'required|date_format:Y',
            'email'             =>  'required|email|unique:users',
            'actor_no'          =>  'required',
            'phone'             =>  'regex:/^\+?\(?\d{2,4}\)?[\d\s-]{3,}$/',    //Example: (043) 12345678

            'address'           =>  'regex:/^' . $character_collection . $symbol_collection_allow . ']+$/u',
            'nation'            =>  'regex:/^' . $character_collection . $symbol_collection_allow . ']+$/u',
            'research_area'     =>  'regex:/^' . $character_collection . $symbol_collection_allow . ']+$/u',
            'research'          =>  'regex:/^' . $character_collection . $symbol_collection_allow . ']+$/u',

        ];
    }

    public function messages()
    {
        return [
            'username.required'     =>  trans('admin.user.register.username.required'),
            'username.max'          =>  trans('admin.user.register.username.max'),
            'username.regex'        =>  trans('admin.user.register.username.regex'),

            'password.required'     =>  trans('admin.user.register.password.required'),
            'password.min'          =>  trans('admin.user.register.password.min'),
            'password.max'          =>  trans('admin.user.register.password.max'),
            'password.confirmed'    =>  trans('admin.user.register.password.confirmed'),

            'last_name.required'    =>  trans('admin.user.register.last_name.required'),
            'last_name.max'         =>  trans('admin.user.register.last_name.max'),
            'last_name.regex'       =>  trans('admin.user.register.last_name.regex'),

            'first_name.required'   =>  trans('admin.user.register.first_name.required'),
            'first_name.max'        =>  trans('admin.user.register.first_name.max'),
            'first_name.regex'      =>  trans('admin.user.register.first_name.regex'),

            'middle_name.regex'     =>  trans('admin.user.register.middle_name.regex'),

            'email.required'        =>  trans('admin.user.register.email.required'),
            'email.email'           =>  trans('admin.user.register.email.email'),
            'email.unique'          =>  trans('admin.user.register.email.unique'),

            'actor_no.required'     =>  trans('admin.user.register.actor_no.required'),           

            'year.required'         =>  trans('admin.user.register.year.required'),
            'year.date_format'      =>  trans('admin.user.register.year.date_format'),

            'phone.regex'           =>  trans('admin.user.register.phone.regex'),

            'address.regex'         =>  trans('admin.user.register.address.regex'),
            'nation.regex'          =>  trans('admin.user.register.nation.regex'),
            'research_area.regex'   =>  trans('admin.user.register.research_area.regex'),
            'research.regex'        =>  trans('admin.user.register.research.regex'),

        ];
    }
}
