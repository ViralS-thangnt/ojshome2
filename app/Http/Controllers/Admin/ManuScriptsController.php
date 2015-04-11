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
			// dd($stage, $result);
			return view('manuscripts.manuscript')->withResult($result)->withStage($stage);
		}

		return view('manuscripts.permission_denied')->withMessage('You can not access this site');
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

	// Reports
	public function showReportRejected()
	{
		$data = $this->repo->getDataReport(Input::get('start'), Input::get('end'), REPORT_REJECTED);

		return view('reports.report')
					->withData($data)
					->withUrl(Constant::$url['report-rejected'])
					->withReport(Constant::$report[REPORT_REJECTED])
					->withPermissions(array($this->repo->getPermission()));
	}

	public function showReportSubmited()
	{
		$data = $this->repo->getDataReport(Input::get('start'), Input::get('end'), REPORT_SUBMITED);

		return view('reports.report')
					->withData($data)
					->withUrl(Constant::$url['report-submited'])
					->withReport(Constant::$report[REPORT_SUBMITED])
					->withPermissions(array($this->repo->getPermission()));
	}

	public function showReportPublishInYear()
	{
		$data = $this->repo->getDataReport(Input::get('start'), Input::get('end'), REPORT_PUBLISH_IN_YEAR);

		return view('reports.report')
					->withData($data)
					->withUrl(Constant::$url['report-publish-in-year'])
					->withReport(Constant::$report[REPORT_PUBLISH_IN_YEAR])
					->withPermissions(array($this->repo->getPermission()));
	}

	public function showReportReviewLoop()
	{
		$data = $this->repo->getDataReport(Input::get('start'), Input::get('end'), REPORT_REVIEW_LOOP);

		return view('reports.report')
					->withData($data)
					->withUrl(Constant::$url['report-review-loop'])
					->withReport(Constant::$report[REPORT_REVIEW_LOOP])
					->withPermissions(array($this->repo->getPermission()));
	}

	public function showReportWithdrawn()
	{
		$data = $this->repo->getDataReport(Input::get('start'), Input::get('end'), REPORT_WITHDRAWN);

		return view('reports.report')
					->withData($data)
					->withUrl(Constant::$url['report-withdrawn'])
					->withReport(Constant::$report[REPORT_WITHDRAWN])
					->withPermissions(array($this->repo->getPermission()));
	}
	
	public function showReportRatioReject()
	{
		$data = $this->repo->getDataReport(Input::get('start'), Input::get('end'), REPORT_RATIO_REJECT);

		return view('reports.report')
					->withData(['start' => $data['start'], 'end' => $data['end'], 'count_manu' => $data['count_manu']['data']])
					->withUrl(Constant::$url['report-ratio-reject'])
					->withReport(Constant::$report[REPORT_RATIO_REJECT])
					->withScreen($data['count_manu']['screen'])
					->withReview($data['count_manu']['review'])
					->withPermissions(array($this->repo->getPermission()));
	}

	public function showReportPublishedDelinquent()
	{
		// dd('report-published-delinquent');
		$data = $this->repo->getDataReport(Input::get('start'), Input::get('end'), REPORT_PUBLISHED_DELINQUENT);

		return view('reports.report')
					->withData($data)
					->withUrl(Constant::$url['report-published-delinquent'])
					->withReport(Constant::$report[REPORT_PUBLISHED_DELINQUENT])
					->withPermissions(array($this->repo->getPermission()));
	}

	public function showReportJournalInYear()
	{
		$data = $this->repo->getDataReport(Input::get('start'), Input::get('end'), REPORT_JOURNAL_IN_YEAR);

		return view('reports.report')
					->withData($data)
					->withUrl(Constant::$url['report-journal-in-year'])
					->withReport(Constant::$report[REPORT_JOURNAL_IN_YEAR])
					->withPermissions(array($this->repo->getPermission()));
	}

	public function showReportReviewTime()
	{
		// dd('report-review-time');
		$data = $this->repo->getDataReport(Input::get('start'), Input::get('end'), REPORT_REVIEW_TIME);

		return view('reports.report')
					->withData($data)
					->withUrl(Constant::$url['report-review-time'])
					->withReport(Constant::$report[REPORT_REVIEW_TIME])
					->withPermissions(array($this->repo->getPermission()));
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

	public function getDataCombobox($field, $value, $key_field_name, $value_field_name)
	{
		$temp = Keyword::where($field, '=', $value)->get();

		$id_arr = $temp->lists($key_field_name);
		$values_arr = $temp->lists($value_field_name);

		return array_combine($id_arr, $values_arr);
	}

	public function getDataComboboxSelected($id, $lang_code)
	{
		$temp = KeywordManuscript::where('manuscript_id', '=', $id)
								->with('keyword')
								->whereHas('keyword', function($q) use($lang_code)
								{
									$q->where('lang_code', $lang_code);
								})
								->get()
								->lists('keyword_id')
								;
		return $temp;
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
		if(!$this->repo->hasPermission(AUTHOR))
		{
			abort(333);
		}

		$keyword_en_selected = null;
		$keyword_vi_selected = null;
		$disabled = false;		// edit or disable control
		$is_new = true;			// new or edit manuscript 
		$need_edit = false;		// need edit again ?
		$is_withdrawn = false;	// withdrawn ?
		$reject_status = REJECTED;	// reject status 
		// $stage = null;

		if($id) 
		{
			$manuscripts = $this->repo->getById($id);

			// if user hasn't permission
			($this->user->id != $manuscripts->author_id) ? abort(333) : '' ;
			
			// Get data for keyword combobox 
			$manuscripts = $this->repo->restoreStatusListbox($manuscripts);
			$keyword_en_selected = $this->getDataComboboxSelected($id, EN);
			$keyword_vi_selected = $this->getDataComboboxSelected($id, VI);

			if($manuscripts) 
			{
				$is_new = false;
				($manuscripts->status == WITHDRAWN) ? $is_withdrawn = true : '';
				($manuscripts->status == IN_SCREENING_EDIT || $manuscripts->status == IN_REVIEW_EDIT) ? $need_edit = true : '';
				// dd($manuscripts->status, IN_REVIEWING_EDIT, IN_SCREENING_EDIT);
			} 
			else
			{
				$manuscripts = $this->repo;
			}
			
			$disabled = $this->repo->checkDisabledEditManuscript($manuscripts);

		} 
		else 
		{
			$manuscripts = $this->repo;
		}

		$keyword_en = $this->getDataCombobox('lang_code', EN , 'id', 'text');
		$keyword_vi = $this->getDataCombobox('lang_code', VI, 'id', 'text');

		return view('manuscripts.form', compact('manuscripts', 'id', 'keyword_en', 'keyword_vi', 'disabled', 'is_new', 'need_edit', 'is_withdrawn'))
					->with('keyword_en_selected', $keyword_en_selected)
					->with('keyword_vi_selected', $keyword_vi_selected)
					;
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(ManuscriptRequest $request, $id = null)
	{	
		// dd(Input::all());

		$this->repo->uploadFile();
		$this->repo->formModify(Input::except('_token', 'confirm'), $id);
		// $this->repo->checkSaveAjax(Input::except('_token', 'confirm'), $id);

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
		// dd($manu_file_id);
		// check auth
		if($this->repo->hasPermissions([CHIEF_EDITOR, SECTION_EDITOR, MANAGING_EDITOR, AUTHOR, COPY_EDITOR, SCREENING_EDITOR, REVIEWER, LAYOUT_EDITOR]))
		{

			$this->repo->downloadFile($manu_file_id);

			return true;
		}
			
		return false;
	}
}
