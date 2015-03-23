<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use Input;
use DateTime;

class ManuscriptRequest extends Request {

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
		$keyword_vi = empty(Input::get('keyword_vi')) ? null : implode(',', Input::get('keyword_vi')); 
		$keyword_en = empty(Input::get('keyword_en')) ? null : implode(',', Input::get('keyword_en')); 
		$type = empty(Input::get('type')) ? null : implode(',', Input::get('type'));
		Input::merge(['keyword_vi' => $keyword_vi, 'keyword_en' => $keyword_en, 'type' => $type, 'send_at' => new DateTime]);

		return [
			'type'					=> 'required', 
			'expect_journal_id'		=> 'numeric', 
			'name'					=> array('required', 'regex:/^[-\w]+(?:\W+[-\w]+){0,20}\W*$/'), //'required|max:20', 
			'summary_vi'			=> array('required', 'regex:/^[-\w]+(?:\W+[-\w]+){149,199}\W*$/'), //'required|min:150|max:200', 
			'keyword_vi'			=> 'required|max:5|min:3', 
			'summary_en'			=> array('required', 'regex:/^[-\w]+(?:\W+[-\w]+){149,199}\W*$/'),//'required|min:150|max:200', 
			'keyword_en'			=> 'required|max:5|min:3', 
			'topic'					=> 'required', 
			'confirm'				=> 'in:1', 
			'file'					=> 'required'
		];
	}

	public function messages()
	{
		return [
			'type.required'			=>	trans('admin.type.required'),
			'expect_journal_id.numeric'	=>	trans('admin.expect_journal_id.numeric'),
			'name.regex'			=>	trans('admin.name.regex'),
			'name.required'			=>	trans('admin.name.required'),
			'summary_vi.required'	=>	trans('admin.summary_vi.required'),
			'summary_vi.regex'		=>	trans('admin.summary_vi.regex'),
			'summary_en.required'	=>	trans('admin.summary_en.required'),
			'summary_en.regex'		=>	trans('admin.summary_en.regex'),

			'keyword_en.required'	=>	trans('admin.keyword_en.required'),
			'keyword_vi.required'	=>	trans('admin.keyword_vi.required'),
			'keyword_vi.max'		=>	trans('admin.keyword_vi.max'),
			'keyword_vi.min'		=>	trans('admin.keyword_vi.min'),
			'keyword_en.max'		=>	trans('admin.keyword_en.max'),
			'keyword_en.min'		=>	trans('admin.keyword_en.min'),

			'topic.required'		=>	trans('admin.topic.required'),
			'confirm.in'			=>	trans('admin.confirm.in'),
			'file.required'			=>	trans('admin.file.required'),
		];
	}

}
