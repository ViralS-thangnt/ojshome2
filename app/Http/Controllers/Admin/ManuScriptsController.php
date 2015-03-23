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
		$result = $this->repo->getByStatus(UNSUBMIT);

		return view('manuscripts.manuscript')->withResult($result)->with(['permissions'	=> $this->repo->getPermission()]);
	}

	public function inScreening()
	{		
		$permissions = explode(',', $this->user->actor_no);

		if(in_array(AUTHOR, $permissions)|| in_array(CHIEF_EDITOR, $permissions)|| in_array(SCREENING_EDITOR, $permissions)|| in_array(MANAGING_EDITOR, $permissions))
		{
			$result = $this->repo->getByStatus(IN_SCREENING);

			return view('manuscripts.manuscript')->withResult($result)->with(['permissions'	=> $this->repo->getPermission()]);
		}
		else {

			return view('manuscripts.permission_denied')->withMessage('You can not access this site');
		}
		
	}

	public function rejected()
	{
		$permissions = explode(',', $this->user->actor_no);

		if(in_array(AUTHOR, $permissions)|| in_array(CHIEF_EDITOR, $permissions)|| in_array(SECTION_EDITOR, $permissions)|| in_array(MANAGING_EDITOR, $permissions))
		{
			$result = $this->repo->getByStatus(REJECTED);

			return view('manuscripts.manuscript')->withResult($result)->with(['permissions'	=> $this->repo->getPermission()]);
		}
		else {

			return view('manuscripts.permission_denied')->withMessage('You can not access this site');
		}
	}

	public function rejectedReview()
	{
		$permissions = explode(',', $this->user->actor_no);

		if(in_array(REVIEWER, $permissions))
		{
			$result = $this->repo->getByStatus(REJECTED_REVIEW);
			return view('manuscripts.manuscript')->withResult($result)->with(['permissions'	=> $this->repo->getPermission()]);
		}
		else
		{
			return view('manuscripts.permission_denied')->withMessage('You can not access this site');
		}
	}

	public function inReview()
	{	
		$result = $this->repo->getByStatus(IN_REVIEW);

		return view('manuscripts.manuscript')->withResult($result)->with(['permissions'	=> $this->repo->getPermission()]);
	}

	public function inEditing()
	{
		$result = $this->repo->getByStatus(IN_EDITING);
		
		return view('manuscripts.manuscript')->withResult($result)->with(['permissions'	=> $this->repo->getPermission()]);
	}

	public function published()
	{	
		$result = $this->repo->getByStatus(PUBLISHED);
		return view('manuscripts.manuscript')->withResult($result)->with(['permissions'	=> $this->repo->getPermission()]);
	}


	public function withdrawn(){
		
		$result = $this->repo->getByStatus(WITHDRAWN);

		return view('manuscripts.manuscript')->withResult($result)->with(['permissions'	=> $this->repo->getPermission()]);

	}

	public function waitReview()
	{	
		$result = $this->repo->getByStatus(WAIT_REVIEW);
		
		return view('manuscripts.manuscript')->withResult($result)->with(['permissions'	=> $this->repo->getPermission()]);
	}

	public function reviewed()
	{	
		$result = $this->repo->getByStatus(M_REVIEWER);
		return view('manuscripts.manuscript')->withResult($result)->with(['permissions'	=> $this->repo->getPermission()]);
	}
	public function all()
	{	
		$result = $this->repo->getByStatus(ALL);

		return view('manuscripts.manuscript')->withResult($result)->with(['permissions'	=> $this->repo->getPermission()]);
	}

	// Reports
	public function showReportRejected()
	{
		$data = $this->repo->getDataReport(Input::get('start'), Input::get('end'), REJECTED);

		return view('reports.report-rejected')
					->withStart($data['start'])
					->withEnd($data['end'])
					->withData($data['count_manu'])
					;
	}
	
	public function getall()
	{	
		$result = $this->repo->getAll();
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
		if($id) {
			$manuscripts = $this->repo->getById($id);
			$manuscripts = $this->repo->restoreStatusListbox($manuscripts);
		} 
		else 
		{
			$manuscripts = $this->repo;
		}
		
		return view('manuscripts.form', compact('manuscripts', 'id'));
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
}
