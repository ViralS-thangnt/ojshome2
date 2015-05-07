<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use App\Http\Requests\ManuscriptRequest;
use App\Lib\Prototype\Interfaces\ManuscriptInterface;

use Input;
use Session;
use App\User;
use App\Manuscript;
use Constant;
use App\Keyword;
use App\KeywordManuscript;
use DB;

class ManuscriptsController extends Controller {

	protected $repo;

	public function __construct(ManuscriptInterface $repo){
		$this->middleware('auth');
		$this->repo = $repo;
		$this->user = \Auth::user();
		\App::setLocale(\Session::get('lang', 'en'));
	}

	public function unsubmit()
	{
		if ($this->repo->hasPermission(AUTHOR)) {
			$result = $this->repo->getColumnTable(UNSUBMIT, AUTHOR);

			return view('manuscripts.manuscript')->withResult($result)->with(['permissions'	=> $this->repo->getPermission()]);	
		}
		
		return view('manuscripts.permission_denied')->withMessage('You can not access this site');
	}

	public function inScreening()
	{			
		if ($this->repo->hasPermissions(Constant::$require_permission[IN_SCREENING])) {
			$result = $this->repo->getColumnTable(IN_SCREENING, $this->user->actor_no);

			return view('manuscripts.manuscript')->withResult($result);
		}

		return view('manuscripts.permission_denied')->withMessage('You can not access this site');
	}

	public function rejected()
	{
		if ($this->repo->hasPermissions(Constant::$require_permission[REJECTED])) {

			return view('manuscripts.manuscript')->withResult($this->repo->getDataRefuse());
		}

		return view('manuscripts.permission_denied')->withMessage('You can not access this site');
	}

	public function rejectedReview()
	{
		if ($this->repo->hasPermission(REVIEWER)) {
			$result = $this->repo->getColumnTable(REJECTED_REVIEW, REVIEWER, REJECTED_REVIEW);

			return view('manuscripts.manuscript')->withResult($result);
		}

		return view('manuscripts.permission_denied')->withMessage('You can not access this site');
	}

	public function inReview()
	{	
		if ($this->repo->hasPermissions(Constant::$require_permission[IN_REVIEW])) {
			$result = $this->repo->getColumnTable(IN_REVIEW, $this->repo->getPermission());

			return view('manuscripts.manuscript')->withResult($result);
		}

		return view('manuscripts.permission_denied')->withMessage('You can not access this site');
	}

	public function inEditing()
	{
		if ($this->repo->hasPermissions(Constant::$require_permission[IN_EDITING])) {
			$result = $this->repo->getColumnTable(IN_EDITING, $this->repo->getPermission());
			$stage = getStageByStatus(IN_EDITING);

			return view('manuscripts.manuscript')->withResult($result)->withStage($stage);
		}

		return view('manuscripts.permission_denied')->withMessage('You can not access this site');
	}

	public function published()
	{	
		if ($this->repo->hasPermissions(array(LAYOUT_EDITOR, CHIEF_EDITOR, AUTHOR, MANAGING_EDITOR, SECTION_EDITOR, COPY_EDITOR))) {
			$result = $this->repo->getColumnTable(PUBLISHED, $this->repo->getPermission());
			if ($this->repo->hasPermission(CHIEF_EDITOR)) {
				$result['view'] = 'manuscripts.editors.includes.publishing.chief';	
			}

			return view('manuscripts.manuscript')->withResult($result);
		}
		
		return view('manuscripts.permission_denied')->withMessage('You can not access this site');
	}


	public function withdrawn(){
		
		$result = $this->repo->getByStatus(WITHDRAWN);

		return view('manuscripts.manuscript')->withResult($result)->with(['permissions'	=> $this->repo->getPermission()]);

	}

	public function waitReview()
	{	
		if ($this->repo->hasPermission(REVIEWER)) {
			$result = $this->repo->getColumnTable(WAIT_REVIEW, REVIEWER, WAIT_REVIEW);

			return view('manuscripts.manuscript')->withResult($result);
		}

		return view('manuscripts.permission_denied')->withMessage('You can not access this site');
	}

	public function reviewed()
	{	
		if ($this->repo->hasPermission(REVIEWER)) {
			$result = $this->repo->getColumnTable(REVIEWED, REVIEWER, REVIEWED);

			return view('manuscripts.manuscript')->withResult($result);
		}

		return view('manuscripts.permission_denied')->withMessage('You can not access this site');
	}
	public function all()
	{	
		$result = $this->repo->getByStatus(ALL);

		return view('manuscripts.manuscript')->withResult($result)->with(['permissions'	=> $this->repo->getPermission()]);
	}



	public function getall()
	{	
		$result = $this->repo->getByStatus(ALL);

		return view('manuscripts.manuscript_admin')->withResult($result);
	}
	public function SoftDeletes()
	{	
		$post_data = Input::all();
		$checkbox_name = [];
		foreach ($post_data as $key => $value) {
			if($value ==='checked'){
				array_push($checkbox_name,$key);
			}
		}
		$this->repo->ManuscriptSoftDeletes($checkbox_name);

		return redirect()->back();
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function form($id = null)
	{
		// Not author, can't access
		$this->repo->checkIsAuthor();

		if($id) 
		{
			$data = $this->repo->getDataFormEditManuscript($id, $this->repo->getById($id));
		} 
		else 
		{
			$data = $this->repo->getDataFormNewManuscript($this->repo);
		}

		return view('manuscripts.form', compact('id'))
					->with($data)
					->with($this->repo->getDataKeyword());
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(ManuscriptRequest $request, $id = null)
	{	
		$this->repo->uploadFile();
		$this->repo->formModify(Input::except('_token', 'confirm'), $id);

		return redirect('/admin');
	}

	public function insert(ManuscriptRequest $request)
	{
		$this->repo->uploadFile();
		$this->repo->formModify(Input::except('_token', 'confirm'), $id);

		return redirect('/admin');
	}

	public function withdrawnManuscript($id)
	{
		// don't check validate by Request

		$this->repo->withdrawnEditManuscript(Input::except('_token'), $id);

		return redirect('/admin');
	}

	public function setLocale() {
		// TODO check lang is valid or exist
		$lang = $_GET['lang'];

		if($lang != '') {
			\Session::put('lang', $lang);
			\App::setLocale($lang);
			return json_encode($lang);
		}
		return json_encode($lang);
	}

	public function downloadFileEditor($manu_file_id)
	{
		// check auth
		if($this->repo->hasPermissions([CHIEF_EDITOR, SECTION_EDITOR, MANAGING_EDITOR, AUTHOR, COPY_EDITOR, SCREENING_EDITOR, REVIEWER, LAYOUT_EDITOR]))
		{

			$this->repo->downloadFile($manu_file_id);

			return true;
		}
			
		return false;
	}
}
