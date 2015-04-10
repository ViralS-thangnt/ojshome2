<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\KeywordRequest;
use Illuminate\Support\Facades\Session;
use App\Lib\Prototype\Interfaces\KeywordInterface;
use Input;

use Illuminate\Http\Request;

class KeywordsController extends Controller {

	protected $keywordRepo;

	public function __construct(KeywordInterface $keyword)
	{
		$this->keyword = $keyword;
		$this->middleware('auth');
		$this->user = \Auth::user();
		\App::setLocale(\Session::get('lang', 'en'));
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$permissions = explode(',', $this->user->actor_no);
		if(in_array(ADMIN, $permissions))
		{
			$keywords = $this->keyword->getAll();
			return view('keywords.index', compact('keywords'))->with(['permissions' => $this->keyword->getPermission()]);
		}
		else
		{
			return view('manuscripts.permission_denied')->withMessage('You can not access this site');
		}
	}

	public function form($id=null)
	{
		$permissions = explode(',', $this->user->actor_no);

		if($id) {


			$keyword = $this->keyword->getById($id);

		} else {

			$keyword = $this->keyword;

		}

		if(in_array(ADMIN, $permissions))
		{
			return view('keywords.form', compact('keyword', 'id'))->with(['permissions' => $this->keyword->getPermission()]);

		} else {

			return view('manuscripts.permission_denied')->withMessage('You can not access this site');
		}
	}
	
	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(KeywordRequest $request, $id=null)
	{
		$this->keyword->formModify(Input::all(), $id);
		return redirect('admin/keyword');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$this->keyword->delete($id);

        Session::flash(SUCCESS_MESSAGE, 'Delete journal successfully');

        return redirect('admin/keyword');
	}

}
