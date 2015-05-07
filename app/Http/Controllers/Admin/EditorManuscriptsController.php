<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use App\Http\Requests\ManuscriptRequest;
use App\Http\Requests\EditorManuscriptRequest;
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
        if ($this->repo->hasPermission(MANAGING_EDITOR)) {
            $data = $this->repo->getManagingEditorViewData($manuscript_id);
            
            // manuscripts.editors.managing
            return view($this->repo->getViewByStatus($data['manuscript']->status))->with($data);
        }

        if ($this->repo->hasPermission(SECTION_EDITOR)) {
            $data = $this->repo->getSectionEditorViewData($manuscript_id);

            return view('manuscripts.editors.section')->with($data);
        }

        if ($this->repo->hasPermission(COPY_EDITOR)) {
            $data = $this->repo->getCopyEditorViewData($manuscript_id);

            return view('manuscripts.editors.copy')->with($data);
        }

        if ($this->repo->hasPermission(LAYOUT_EDITOR)) {
            $data = $this->repo->getLayoutEditorViewData($manuscript_id);

            return view('manuscripts.editors.layout')->with($data);
        }

        if ($this->repo->hasPermission(AUTHOR)) {
            $data = $this->repo->getAuthorViewData($manuscript_id);
            
            return view('manuscripts.author.detail')->with($data);
        }

        if ($this->repo->hasPermission(CHIEF_EDITOR)) {
            $data = $this->repo->getChiefViewData($manuscript_id);

            return view('manuscripts.editors.chief')->with($data);
        }

        $data = $this->repo->getViewDataById($manuscript_id);

        return view($this->repo->getViewByStatus($data['manuscript']->status))->with($data);
    }

    public function update(EditorManuscriptRequest $request, $manuscript_id, $id = null)
    {
        $data = Input::except('_token');

        if ($this->repo->hasPermission(SECTION_EDITOR)) {
            $this->repo->saveSectionEditor($data, $manuscript_id, $id);

            return redirect('/admin');
        }

        if ($this->repo->hasPermission(CHIEF_EDITOR)) {
            $this->repo->saveChiefEditor($data, $manuscript_id, $id);

            return redirect('/admin');
        }

        if ($this->repo->hasPermission(COPY_EDITOR)) {
            $this->repo->saveCopyEditor($data, $manuscript_id, $id);

            return redirect('/admin');
        }

        if ($this->repo->hasPermission(LAYOUT_EDITOR)) {
            $this->repo->saveLayoutEditor($data, $manuscript_id, $id);

            return redirect('/admin');
        }

        if ($this->repo->hasPermission(AUTHOR)) {
            $this->repo->saveEditorManuscript($data, $manuscript_id, $id);

            return redirect('/admin');
        }

        $this->repo->formModifyEditor($data, $manuscript_id, $id);
        Session::flash(SUCCESS_MESSAGE, 'Update successfully');

        return redirect('/admin');
    }

    public function ajaxUpdate()
    {
        // return Input::all();
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