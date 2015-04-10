<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use App\Http\Requests\ManuscriptRequest;
use App\Lib\Prototype\Interfaces\ManuscriptInterface as ManuscriptRepository;

use Input;
use Session;
use App\User;
use App\Manuscript;
use App\EditorManuscript;

class EditorManuscriptsController extends Controller
{
    protected $repo;

    public function __construct(ManuscriptRepository $repo){
        $this->middleware('auth');
        $this->repo = $repo;
        $this->user = \Auth::user();
        \App::setLocale(\Session::get('lang', 'en'));
    }

    public function form($manuscript_id)
    {
        $data = $this->repo->getViewDataById($manuscript_id);

        return view($this->repo->getViewByStatus($data['manuscript']->status))->with($data);
    }

    public function update($manuscript_id, $id = null)
    {
        // dump($_FILES);
        // dump(Input::all());
        // dd(Input::all());
        $data = Input::except('_token');
        $this->repo->formModifyEditor($data, $manuscript_id, $id);
        Session::flash(SUCCESS_MESSAGE, 'Update successfully');

        return redirect('/admin');
    }

    public function ajaxUpdate()
    {
        //can phai check update: neu btv so loai da ra quyet dinh thi ko dc update editor_id vao manuscript nua!
        if (Input::has('editor_id')) {
            if ($this->repo->update(Input::get('manuscript_id'), ['editor_id' => Input::get('editor_id')])) {
                return trans('admin.response.success');
            }   
        }

        if (Input::has('section_editor_id')) {
            if ($this->repo->update(Input::get('manuscript_id'), ['section_editor_id' => Input::get('section_editor_id')])) {
                return trans('admin.response.success');
            }
        }

        if (Input::has('reviewer_ids')) {

            //return Input::get('reviewer_names');
            $data = [
                'invite_reviewer_ids' => Input::get('reviewer_ids'),
                'deadline_at'         => dateToTimestamp(Input::get('deadline')),
                'delivery_at'         => date('Y-m-d H:i:s'),
            ];
            if ($this->repo->update(Input::get('manuscript_id'), $data)) {
                return trans('admin.response.success');
            }
        }
    }
}