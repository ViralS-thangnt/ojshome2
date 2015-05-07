<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\JournalRequest;
use Illuminate\Support\Facades\Session;
use App\Lib\Prototype\Interfaces\JournalInterface;

use Input;

use Illuminate\Http\Request;

class JournalsController extends Controller {

	protected $journalRepo;

	public function __construct(JournalInterface $journal)
	{
		$this->journal = $journal;
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
		if($this->journal->hasPermission(CHIEF_EDITOR))
		{
			$journals = $this->journal->getAll();

			return view('journals.index', compact('journals'));
		}

		return view('manuscripts.permission_denied')->withMessage('You can not access this site');
	}

	//Display listing of unpublish journals
	public function unpublish()
	{
		if($this->journal->hasPermission(CHIEF_EDITOR))
		{
			$journals = $this->journal->getUnpublish();

			return view('journals.index', compact('journals'));
		}

		return view('manuscripts.permission_denied')->withMessage('You can not access this site');
	}

	//Display listing of published journals
	public function published()
	{
		if($this->journal->hasPermission(CHIEF_EDITOR))
		{
			$journals = $this->journal->getPublished();

			return view('journals.index', compact('journals'));
		}

		return view('manuscripts.permission_denied')->withMessage('You can not access this site');
	}

	public function show($id)
	{
		if ($this->journal->hasPermission(CHIEF_EDITOR)) {
			$journal = $this->journal->getManuscriptsById($id);
			$manuscripts = $this->journal->getUnOrderManuscript();

			return view('journals.detail', compact('journal', 'manuscripts', 'id'));
		}

		return view('manuscripts.permission_denied')->withMessage('You can not access this site');

	}

	//Reorder manuscript in journal
	public function position($id, $manuscript_id, $order = 'up')
	{
		if ($this->journal->hasPermission(CHIEF_EDITOR)) {
			$order = ($order == 'up') ? $order : 'down';
			$this->journal->orderManuscript($id, $manuscript_id, $order);
			
			return redirect('admin/journal/'.$id.'/detail');
		}

		return 'chim cut';
	}

	//Remove manuscript from journal
	public function removeManuscript($id, $manuscript_id)
	{
		if ($this->journal->hasPermission(CHIEF_EDITOR)) {
			$this->journal->removeManuscript($id, $manuscript_id);

			return redirect('admin/journal/'.$id.'/detail');
		}

		return 'chim cut';
	}

	public function addManuscript($id, $manuscript_id)
	{
		if ($this->journal->hasPermission(CHIEF_EDITOR)) {
			$this->journal->addManuscript($id, $manuscript_id);

			return redirect('admin/journal/'.$id.'/detail');
		}

		return 'chim cut';
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function form($id = null)
	{
		$permissions = explode(',', $this->user->actor_no);
		if ($id) {

            $journal = $this->journal->getById($id);

        } else {

            $journal = $this->journal;

        }

        // if(in_array(ADMIN, $permissions)|| in_array(CHIEF_EDITOR, $permissions))
        if(in_array(CHIEF_EDITOR, $permissions))
		{

        	return view('journals.form', compact('journal', 'id'))->with(['permissions'	=> $this->journal->getPermission()]);
		}
        else
		{
			return view('manuscripts.permission_denied')->withMessage('You can not access this site');
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(JournalRequest $request, $id=null)
	{
		$this->journal->formModify(Input::all(), $id);

        return redirect('admin/journal');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$this->journal->deleteJournal($id);

        return redirect('admin/journal');
	}

	// public function destroy1()
	// {
	// 	dd('ok');
	// }

}
