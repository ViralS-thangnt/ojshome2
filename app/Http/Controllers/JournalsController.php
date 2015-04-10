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
		$permissions = explode(',', $this->user->actor_no);

		if(in_array(ADMIN, $permissions)|| in_array(CHIEF_EDITOR, $permissions))
		{
			$journals = $this->journal->getAll();

			return view('journals.index', compact('journals'))->with(['permissions'	=> $this->journal->getPermission()]);
		}
		else
		{
			return view('manuscripts.permission_denied')->withMessage('You can not access this site');
		}
		
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

        if(in_array(ADMIN, $permissions)|| in_array(CHIEF_EDITOR, $permissions))
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
		$this->journal->delete($id);

        Session::flash(SUCCESS_MESSAGE, 'Delete journal successfully');

        return redirect('admin/journal');
	}

}
