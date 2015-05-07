<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class EditorManuscriptRequest extends Request {

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
		$user = \Auth::user();

		if ($user->actor_no == COPY_EDITOR && Request::has('is_revise')) {

			return ['file' => 'required'];
		}

		if ($user->actor_no == LAYOUT_EDITOR) {
			
			return ['file' => 'required|mimes:pdf'];
		}

		return [];
	}

}
