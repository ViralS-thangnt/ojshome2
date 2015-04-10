<?php namespace App\Lib\Prototype\DBClasses\Eloquent;

use Illuminate\Contracts\Auth\Guard;
use App\Lib\Prototype\BaseClasses\AbstractEloquentRepository;
use App\Lib\Prototype\Interfaces\ManuscriptInterface;
use App\Lib\Prototype\Interfaces\UserInterface as UserReopsitory;
use App\Manuscript;
use App\Journal;
use App\ManuscriptFile;
use App\EditorManuscript;
use App\KeywordManuscript;
use App\User;
use URL;
use Input;
use Session;
use Constant;
use Redirect;
use DateTime;
use DB;

// use ConstantArray;


class EloquentManuscriptRepository extends AbstractEloquentRepository implements ManuscriptInterface
{

    protected $editor_model;
    protected $user_repo;

    public function __construct(Manuscript $model, EditorManuscript $editor_model, UserReopsitory $user_repo)
    {
        $this->model = $model;
        $this->editor_model = $editor_model;
        $this->user_repo = $user_repo;
        $this->user = \Auth::user();
    }

    public function formModify($data, $id = null)
    {
        if ($id) {
            $manuscript = $this->model->find($id);
        } else {
            $manuscript = $this->model;
        }

        $data['author_id'] = $this->user->id;
        $manuscript->fill($data);
        $manuscript->status = (Input::get('status') == UNSUBMIT) ? UNSUBMIT : IN_SCREENING;
        $manuscript->save();

        // manuscript id just insert to database
        $key_manu = DB::getPdo()->lastInsertId();

        //Constant::$keyword_type[VI]
        $this->saveKeywords(Input::get('keyword_vi'), Input::get('keyword_en'), $key_manu, $id);

        // save files information
        $this->saveManuscriptFiles($id, $this->user->id, $key_manu);

        return $manuscript;
    }

    public function saveKeywords($keyword_vi, $keyword_en, $key_manu, $id)
    {
        $keyword_vi = explode(',', $keyword_vi);    // Example: 4,7,12, 
        $keyword_en = explode(',', $keyword_en);    // Example: 1,2,5, 
        
        if($id) // Example: 101
        {   
            // Delete old keywords
            $this->deleteOldKeywords($id);
        }
        
        // save keyword_en
        $this->saveKeywordManuscript($keyword_en, $id, $key_manu);
        
        // save keyword_vi
        $this->saveKeywordManuscript($keyword_vi, $id, $key_manu);

    }

    public function deleteOldKeywords($id)
    {
        $k = KeywordManuscript::where('manuscript_id', '=', $id)->get();
        foreach ($k as $value) {
            $value->delete();
        }
    }

    public function saveKeywordManuscript($keyword_arr, $id, $key_manu = null)
    {
        foreach ($keyword_arr as $value) {
            $k = new KeywordManuscript;
            $k->manuscript_id = ($key_manu) ? $key_manu : $id;
            $k->keyword_id = $value;
            $k->save();
        }
    }

    public function saveManuscriptFiles($manu_id, $user_id, $new_key_manu_id = null, $type = null, $new_key_manu_file_id = null)
    {
        
        if(Session::has(FILE_UPLOAD_SESSION))
        {
            if($manu_id)
            {   
                
                if($new_key_manu_file_id)
                {
                    $manu = ManuscriptFile::find($new_key_manu_file_id);
                }
                else
                {
                    //edit manu
                    $manu = ManuscriptFile::where('user_id', $user_id)
                                    ->where('manuscript_id', $manu_id)
                                    ->first();
                }
                                    
            }
            else
            {
                // new manu
                $manu = new ManuscriptFile;
                $manu->manuscript_id = $new_key_manu_id;
                // dump('saveManuscriptFiles');
            }

            // TODO: need delete old file (soft delete or hard delete ?)

            //

            if(!$manu)
            {
                Session::flash(SUCCESS_MESSAGE, 'Lỗi upload file: Không có File tương ứng với bản thảo được up lên trước đây ');
                $manu = new ManuscriptFile;
                $manu->manuscript_id = $manu_id;
            }

            $manu->user_id = $user_id;
            $manu->name = Session::get(FILE_UPLOAD_SESSION);
            if ($type) {
                $manu->type = $type;
            }
            // $manu->type = Session::has('FILE_UPLOAD_TYPE') ? Session::get('FILE_UPLOAD_TYPE') : '';
            $manu->total_page = Session::has(FILE_UPLOAD_TOTAL_PAGE) ? Session::get(FILE_UPLOAD_TOTAL_PAGE) : 0;
            $manu->extension = Session::has(FILE_UPLOAD_EXTENSION) ? Session::get(FILE_UPLOAD_EXTENSION) : '';

            $manu->save();

            return $manu;
        }

        return null;
    }

    public function checkSaveAjax($manu_id, $editor_id, $stage = SCREENING)
    {
        $editor_manu = EditorManuscript::where('manuscript_id', $manu_id)
                                        ->where('stage', SCREENING)
                                        ->get()
                                        ;
        $editor_manu->stage = $stage;
        $editor_manu->save();

        return $editor_manu;
    }

    public function checkDisabledEditManuscript($manuscripts)
    {
        $stage = getStageByStatus($manuscripts->status);
        $disabled = false;
        $status = $manuscripts->status;

        if(($stage == SCREENING && $status == IN_SCREENING) or 
            ($stage == REVIEWING && $status == IN_REVIEW) or 
            ($stage == EDITING) or 
            ($stage == PUBLISHING))
        {
            $disabled = true;
        }

        return $disabled;
    }

    public function withdrawnEditManuscript($data, $manu_id)
    {
        $manuscript = Manuscript::find($manu_id);
        if($manuscript) 
        {
            $manuscript->status = WITHDRAWN;
            $manuscript->save();

            return true;
        } 

        return false;
    }

    public function update($id, $data)
    {
        return $this->model->where('id', $id)->update($data);
    }

    public function getViewByStatus($status)
    {
        $permissions = $this->getPermissions();
        $permission = $permissions[0];

        return Constant::$view_manuscript_editor[$permission];
    }

    public function getViewDataById($manuscript_id)
    {
        $data = ['manuscript' => $this->getByIdWith($manuscript_id)];
        if ($data['manuscript']->editorManuscript) {
            $data['editorManuscript_id'] =  $data['manuscript']->editorManuscript->id;
            $data['loop'] = $data['manuscript']->editorManuscript->loop; 
            $data['disable_edit'] = ($data['manuscript']->editorManuscript->is_sent) ? true : false;
        } else {
            $data['editorManuscript_id'] = null;
            $data['loop'] = 1;
            $data['disable_edit'] = false;
        }
        
        if ($this->hasPermission(AUTHOR)) 
        {
            // Get manuscript file id of layout editor (LAYOUT_PRINT_FILE)
            $data['layout_print_file_id'] = $this->getFileManuscriptLayoutEditor($data['manuscript']->id, 
                                                                            $data['manuscript']->layout_editor_id, 
                                                                            LAYOUT_PRINT_FILE);
            $data['section_editor'] = User::find($data['manuscript']->editor_id);

            return $data;
        }

        if ($this->hasPermission(MANAGING_EDITOR)) 
        {
            //get list invite reviewers
            $data['reviewed_list'] = $this->user_repo->getByIds($data['manuscript']->reviewer_ids);
            //get list rejected reviewers
            $data['reject_list'] = $this->user_repo->getByIds($data['manuscript']->reject_reviewer_ids);
            //get list invite reviewer
            $data['invite_list'] = $this->user_repo->getByIds($data['manuscript']->invite_reviewer_ids);
        }

        // if ($this->hasPermission(COPY_EDITOR)) 
        // {
        //     $data = $this->getDataForCopyEditor($data);
        // }

        //check if current user is in rejected reviewer list
        if (findInSet($this->user->id, $data['manuscript']->reject_reviewer_ids)) 
        {
            $data['rejected_user'] = true;
        } else {
            $data['rejected_user'] = false;
        }

        $data['stage'] = getStageByStatus($data['manuscript']->status);
        $data['current_id'] = makeCurrentId($manuscript_id, $data['stage'], $data['loop']);  

        switch ($data['manuscript']->status) {
            case IN_SCREENING:
                $data = $this->getDataForInScreening($data);
                break;

            case IN_REVIEW:
                $data = $this->getDataForInReview($data, $manuscript_id);
                break;

            case IN_EDITING:
                $data = $this->getDataForInEditing($data);
                break;
            default:
                
                break;
        }

        return $data;
    }

    public function getDataForInScreening($data)
    {
        if ($this->hasPermission(MANAGING_EDITOR)) 
        {
            $data['screening_editors'] = $this->user_repo->getListIds(SCREENING_EDITOR);
            // Get info screening editors by manuscript id and stage = IN_SCREENING
            $data['screening_editors_info'] = $this->getScreeningEditorByManuscriptAndStage($data['manuscript']->id, SCREENING);
        }
        else if($this->hasPermission(SCREENING_EDITOR))
        {
            //screening editor
            $data['reviewers'] = $this->user_repo->getListIds(REVIEWER);
        }

        return $data;
    }

    public function getDataForInReview($data, $manuscript_id)
    {
        if ($this->hasPermission(MANAGING_EDITOR)) 
        {
            // dd($data);
            $data['section_editors'] = $this->user_repo->getListIds(SECTION_EDITOR);
            $data['reviewers'] = $this->user_repo->getListIds(REVIEWER);

            // Get info screening editors by manuscript id and stage = IN_SCREENING
            $data['screening_editors_info'] = $this->getScreeningEditorByManuscriptAndStage($data['manuscript']->id, SCREENING);
            
        } 
        else if($this->hasPermission(SECTION_EDITOR))
        {

            // section editor
            $temp = $this->getReviewerEditorAndCommentsById($manuscript_id, \Auth::user());
            $data['reviewers_comments'] = $temp['reviewer'];
            $data['section_editor_comments'] = $temp['section_editor'];

        }

        return $data;
    }

    public function getDataForInEditing($data)
    {
        // Get data for IN_EDITING status
        if ($this->hasPermission(COPY_EDITOR)) 
        {
            // dd('saj');
            $data = $this->getDataForCopyEditorInEditing($data);
        }
        else if ($this->hasPermission(SECTION_EDITOR)) 
        {

        } 
        else if ($this->hasPermission(MANAGING_EDITOR)) 
        {

        } 
        else if ($this->hasPermission(AUTHOR)) 
        {

        }
        else if ($this->hasPermission(LAYOUT_EDITOR)) 
        {
            $data = $this->getDataForLayoutEditorInEditing($data);
        }

        return $data;
    }

    public function getDataForLayoutEditorInEditing($data)
    {

        if($data['manuscript']->is_pre_public == NOT_PRE_PUBLIC)
        {
            // layout_print (Chế bản)
            // Get info manuscript file of copy_editor
            $data['layout_editor_file_id'] = $this->getFileManuscriptLayoutEditor($data['manuscript']->id, $data['manuscript']->editor_id, REVISE_FILE);
        }
        else
        {
            // pre public (Kiểm bông)
            // LAYOUT_PRINT_FILE
            $data['layout_editor_file_id'] = $this->getFileManuscriptLayoutEditor($data['manuscript']->id, \Auth::user()->id, LAYOUT_PRINT_FILE);
        }

        $data['copy_editor_comments'] = EditorManuscript::with('user')->where('manuscript_id', $data['manuscript']->id)
                                                        ->where('user_id', $data['manuscript']->editor_id)
                                                        ->where('current_id', $data['manuscript']->current_editor_manuscript_id)
                                                        ->first();
        $data['copy_editor'] = $data['copy_editor_comments']->user;
        // dd($data);

        return $data;
    }

    public function getDataForCopyEditorInEditing($data)
    {
        if($data['manuscript']->is_pre_public == PRINT_OUT)
        {
            // copy editor 
            // Get information of manuscript file of layout editor
            $data['layout_print_file_id'] = $this->getFileManuscriptLayoutEditor($data['manuscript']->id, 
                                                                            $data['manuscript']->layout_editor_id, 
                                                                            LAYOUT_PRINT_FILE);
            // Get information of layout editor
            $data['layout_editor'] = User::find($data['manuscript']->layout_editor_id);

            $data['comments'] = $data['manuscript']->editorManuscript['comments'];
        }
        else
        {
            //get list Layout Editor
            $data['layout_editors'] = $this->user_repo->getListIds(LAYOUT_EDITOR);
        }

        return $data;
    }

    public function getFileManuscriptLayoutEditor($manu_id, $editor_id, $type = REVISE_FILE)
    {
        $manu_file = ManuscriptFile::where('manuscript_id', $manu_id)
                                    ->where('user_id', $editor_id)
                                    ->where('type', $type)
                                    ->first();
                                    // dd($manu_file);
        if($manu_file)
        {
            return $manu_file->id;
        }

        return null;
    }

    // Get screening editors of manuscript
    public function getScreeningEditorByManuscriptAndStage($manuscript_id, $stage)
    {
        // dump($manuscript_id, $stage);
        $editor_manu = EditorManuscript::with('user')
                                ->where('manuscript_id', $manuscript_id)
                                ->where('stage', $stage)
                                // ->with('manuscript')
                                ->get()
                                ;
                                // dump($editor_manu);
                                // dd($editor_manu);
        $data = array();
        if($editor_manu)
        {
            foreach ($editor_manu as $value) {
                // dump($value->user);
                $data['id'] = $value->id;
                $data['name'] = $value->user['last_name'] . '  ' . $value->user['middle_name'] . '  ' . $value->user['first_name'] ;
                $data['loop'] = $value->loop;
                $data['stage'] = $value->stage;
                $data['comments'] = $value->comments;
            }
        }
        // dd($data);

        return $data;
    }


    // Get list reviewer and reviewer's comments
    public function getReviewerEditorAndCommentsById($manuscript_id, $section_editor)
    {
        $reviewer = EditorManuscript::with('user')
                                    ->where('manuscript_id', $manuscript_id)
                                    ;
        $data = array();
        foreach ($reviewer->get() as $value) {
            // dump($value);
            if($value->user->id == $section_editor->id)
            {
                $data['section_editor'] = array(
                    'name'      =>  $section_editor->last_name . ' ' . $section_editor->middle_name . ' ' . $section_editor->first_name,
                    'comments'  =>  $value->comments,
                    'loop'      =>  $value->loop,
                    'decide'    =>  ($value->decide) ? $value->decide : 0);
            }
            else
            {
                $data['reviewer'][$value->user->id] = array(
                    'name'      =>  $value->user->last_name . ' ' . $value->user->middle_name . ' ' . $value->user->first_name,
                    'comments'  =>  $value->comments,
                    'loop'      =>  $value->loop,
                    'decide'    =>  ($value->decide) ? $value->decide : 0);
            }
        }

        // if section editor not exist in Editor manuscript table
        if(!isset($data['section_editor']))   
        {
            $data['section_editor'] = array(
                    'name'      =>  '',
                    'comments'  =>  '',
                    'loop'      =>  0,
                    'decide'    =>  0);
        }
        // dd($data);
        return $data;
    }

    public function formModifyEditor($data, $id, $editor_manuscript_id = null)
    {
        // dump(Input::all());
        //         dd($data);

        //reviewer reject review
        if (isset($data['rejected']) && $data['rejected']) {
            $this->updateReviewerList($id);

            return null;
        }

        $manuscript = $this->model->find($id);
        //check if current user still have assign permission
        if (!$this->checkAssignPermission($manuscript)) {
            return null;
        }

        if(isset($data['ass_scr_editor']))
        {
            $editor_manu = new EditorManuscript;
            $editor_manu->manuscript_id = $data['manuscript_id'];
            $editor_manu->user_id = $data['editor_id'];
            $editor_manu->current_id = makeCurrentId($editor_manu->manuscript_id, SCREENING, 1);
            
            $editor_manu->stage = SCREENING;
            $editor_manu->save();

            $manu = Manuscript::find($data['manuscript_id']);
            $manu->current_editor_manuscript_id = $editor_manu->current_id;
            $manu->save();

            // redirect()->back();
            return null;
        }

        //save comment and decide
        if ($editor_manuscript_id) {
            $editor_manuscript = $this->editor_model->find($editor_manuscript_id);
        } else {
            $editor_manuscript = $this->editor_model;
        }
        isset($data['decide']) ? $data['decide'] = current($data['decide']) : ''; 
        $data['manuscript_id'] = $id;
        $data['user_id'] = $this->user->id;
        $editor_manuscript->fill($data);  
        $editor_manuscript->save();

        // $data = $this->saveEditorManuscript($data, $id, $editor_manuscript_id);

        if ($this->hasPermission(SCREENING_EDITOR)) {
            $manuscript->status = IN_SCREENING;
            $manuscript->save();
        }

        if ($this->hasPermission(SECTION_EDITOR)) {
            $manuscript = $this->sectionEditorUploadFile($id, $manuscript, $data, $this->user->id);

            return null;
        }

        if ($this->hasPermission(REVIEWER)) {
            $this->updateReviewerList($id, false);
            
            // Upload file with file type = REVIEWER_FILE
            if (isset($data['file']) and !empty($data['file'])) {
                
                $this->uploadFileEditor($id, $this->user->id, REVIEWER_FILE);
            } 

            return null;
        }

        //copy editor 
        if (isset($data['is_revise'])) {
            // Upload file hiệu đính
            $manuscript = $this->copyEditorUploadFileRevise($manuscript, $data, $this->user->id);
            return null;
        }

        if ($this->hasPermission(LAYOUT_EDITOR) and isset($data['is_print_out'])) {
            $manuscript = $this->layoutEditorUploadPrintOut($manuscript, $id, $this->user->id);

            return null;
        }

        if (isset($data['is_layout_print_comment'])) {
            // copy editor comment to layout print
            
            return null;
        }

        if ($this->hasPermission(LAYOUT_EDITOR) and isset($data['start_publish'])) {
            // Start publishing stage
            $manuscript = $this->layoutEditorStartPublish($manuscript, $id);
            
            return null;
        }

        $manuscript->status = $this->nextStatus($manuscript->status, $data['decide'], $id);
        // dump($manuscript);
        // dd($data);
        $stage = getStageByStatus($manuscript->status);
        if (!in_array($manuscript->status, [IN_SCREENING_REFUSE, IN_REVIEW_REFUSE, IN_SCREENING_EDIT, IN_REVIEW_EDIT])) {
            $manuscript->current_editor_manuscript_id = makeCurrentId($id, $stage, 1);
        }

        $manuscript->save();
        // dump($editor_manuscript);
        // dd($data);
        if($data['is_sent'] == 1 and $data['decide'] == ACCEPT) 
        {
            $editor_manuscript->stage = $stage++;
            $editor_manuscript->save();
        }

    }


    public function saveEditorManuscript($data, $id, $editor_manuscript_id)
    {
        if ($editor_manuscript_id) {
            $editor_manuscript = $this->editor_model->find($editor_manuscript_id);
        } else {
            $editor_manuscript = $this->editor_model;
        }
        isset($data['decide']) ? $data['decide'] = current($data['decide']) : ''; 
        $data['manuscript_id'] = $id;
        $data['user_id'] = $this->user->id;
        $editor_manuscript->fill($data);  
        $editor_manuscript->save();

        return $data;
    }

    public function sectionEditorUploadFile($id, $manuscript, $data, $user_id)
    {
        // Upload file with file type = SE_FILE
        if (isset($data['file'])) {
            $this->uploadFileEditor($id, $user_id, SE_FILE);
        }
        
        $manuscript->is_review = current($data['is_review']);
        $manuscript->save();

        // create new editor manuscript
        $editor_manu = EditorManuscript::where('current_id', $manuscript->current_editor_manuscript_id)->first();

        if(count($editor_manu) == 0)
        {
            $editor_manu = new EditorManuscript;
            $editor_manu->current_id = $manuscript->current_editor_manuscript_id;
            $editor_manu->stage = REVIEWING;
            $editor_manu->manuscript_id = $manuscript->id;
            $editor_manu->user_id = \Auth::user()->id;
        }

        $editor_manu->section_editor_decide = $data['decide'];
        ($manuscript->is_review == NOT_NOTIFY) ? ($editor_manu->is_sent = 0) : '';
        $editor_manu->save();
       
        return $manuscript;
    }

    public function copyEditorUploadFileRevise($manuscript, $data, $user_id)
    {
        // dd($data, $manuscript->editor_id);

        // hiệu đính, kết thúc công việc của copy editor trong phần hiệu đính
        // cho theo dõi đến khi xuất bản
        $manuscript->is_revise = $data['is_revise'];

        // select layout editor id
        $manuscript->layout_editor_id = $data['layout_editor_id'];

        $manuscript->save();
        // dd($data);
        // Upload file with file type = REVISE_FILE
        if (isset($data['file']) and !empty($data['file'])) {
            // lựa chọn file do copy editor upload lên
            $this->uploadFileEditor($id, $user_id, REVISE_FILE, null, NEW_MANUSCRIPT_FILE);
        } 
        else
        {
            // nếu ko có file do copy editor upload lên, lựa chọn phiên bản của tác giả
            // $this->createNewManuscriptFile($id, $this->user->id, REVISE_FILE, NEW_MANUSCRIPT_FILE);
            $this->uploadFileEditor($id, $user_id, REVISE_FILE, null, COPY_MANUSCRIPT_FILE);
        }

        return $manuscript;

    }

    public function layoutEditorUploadPrintOut($manuscript, $id, $user_id)
    {
        // Layout editor upload file PDF for author and copy editor
        $manuscript->is_print_out = $data['is_print_out'];

        // Tranfer to PRE_PUBLIC
        $manuscript->is_pre_public = PRE_PUBLIC;

        // Save
        $manuscript->save();

        if($_FILES['file']['type'] == FILE_TYPE_PRINT_OUT)
        {
            $this->uploadFileEditor($id, $user_id, LAYOUT_PRINT_FILE, null, NEW_MANUSCRIPT_FILE);
        }

    }

    public function layoutEditorStartPublish($manuscript, $id)
    {
        // dd($this->user->id);
        // layout editor kích hoạt giai đoạn xuất bản
            // Tranfer to PUBLISH
            $manuscript->status = PUBLISHED;

            // Create new current_id
            $manuscript->current_editor_manuscript_id = makeCurrentId($id, getStageByStatus($manuscript->status), 1);
            
            $manuscript->save();

            // Create new Editor Manuscript
            $new = new EditorManuscript;
            $new->current_id = $manuscript->current_editor_manuscript_id;
            $new->stage = PUBLISHING;
            $new->manuscript_id = $manuscript->id;
            $new->user_id = \Auth::user()->id;
            $new->loop = 1;
            $new->save();

            return $manuscript;
    }


    public function checkAssignPermission($manuscript)
    {
        if ($this->hasPermission(SCREENING_EDITOR) && $manuscript->editor_id != $this->user->id) {

            return false;
        }

        return true;
    }

    public function updateReviewerList($id, $is_reject_list = true)
    {
        $manuscript = $this->model->find($id);
        if ($is_reject_list) {
            $data = popAndPush($manuscript->invite_reviewer_ids, $manuscript->reject_reviewer_ids, $this->user->id);
            $manuscript->reject_reviewer_ids = $data['set2'];
        } else {
            $data = popAndPush($manuscript->invite_reviewer_ids, $manuscript->reviewer_ids, $this->user->id);
            $manuscript->reviewer_ids = $data['set2'];
        }

        $manuscript->invite_reviewer_ids = $data['set1'];
        $manuscript->save();

        return $manuscript;
    }

    public function nextStatus($current_status, $decide, $id)
    {
        if ($current_status == IN_SCREENING) {
            switch ($decide) {
                case REFUSE:
                    return IN_SCREENING_REFUSE;
                case ACCEPT:
                    return IN_REVIEW;
                case REQUIRE_EDIT:
                    return IN_SCREENING_EDIT;//if author resubmit manuscript it will return status IN_SCREENING next loop
                default:
                    return IN_SCREENING_REFUSE;
            }
        }

        if ($current_status == IN_REVIEW) {
            switch ($decide) {
                case REFUSE:
                    return IN_REVIEW_REFUSE;
                case ACCEPT:
                    return IN_EDITING;
                case REQUIRE_EDIT:
                    return IN_REVIEW_EDIT;
                default:
                    # code...
                    break;
            }
        }
    }



    public function getByIdWith($id)
    {
        $relations = ['manuscriptFiles'];
        if ($this->hasPermission(MANAGING_EDITOR)) {
            $relations[] = 'editorManuscript';
        } else {
            $relations['editorManuscript'] = function($query) {
                                $query->where('user_id', $this->user->id);
                            };
        }

        if ($this->hasPermissions([CHIEF_EDITOR, SECTION_EDITOR, MANAGING_EDITOR])) { 
            $relations['currentEditorManuscripts'] = function($query) {
                $query->where('user_id', '!=', $this->user->id);
            };

            $relations['currentEditorManuscripts.user'] = function($query) {
                $query->where('id', '!=', $this->user->id);
            };
        }

        $query = $this->make($relations);

        return $query->findOrFail($id);
    }

	public function getByStatus($status = null){
		switch ($status) {
			case IN_REVIEW:				
				$data = $this->getDataInReview($this->user, $status);
				break;
			case UNSUBMIT:
				$data = $this->getUnsubmit();
                break;
            case REJECTED:
                return $this->getDataRejected($this->user, $status);
                break;
            case IN_SCREENING:
                $data = $this->getDataInScreening($this->user, $status);
                break;
            case REJECTED_REVIEW:
                $data = $this->getDataRejectedReview($this->user, $status);
                break;
			case REVIEWED:				
				//$data = $this->getDataReviewer($this->user, $status);
                $data = $this->getReviewed();
				break;
            case IN_EDITING:
                $data = $this->getInEditing();
                break;
			case PUBLISHED:
				$data = $this->getDataPublished($this->user, $status);

            case WITHDRAWN:
                $data = $this->getDataWithDrawn($this->user, $status);
                break;
            case WAIT_REVIEW:
                //$data = $this->getDataWaitReview($this->user, $status);
                $data = $this->getWaitReview();
                break;
            case ALL:
                $data = $this->getDataAll($this->user);
                break;
			default:
				$data = $this->getDataPublished($this->user, $status);
				break;
		}

		return $data;
	}
//=======================================================================
// hàm dùng để xóa mềm bản thảo 
// các biến được sử dụng trong hàm
// $result  : array('key'=>'value')
// ======================================================================

    public function ManuscriptSoftDeletes($result){
        $this->model->deleteManuscript($result); 
        return true;
    }

    private function baseManuscrip($col)
    {
        Manuscript::selectColumns($col);


    }


//=======================================================================
// hàm dùng để lấy data cho trang http://..../admin/manuscript/all
// các biến được sử dụng trong hàm
// view chỉ dùng cho 'nhà phản biện'
// $col        : các columns cần lấy ra 
// $col_header : tiêu đề của bảng hiển thị
// $key        : tên columns
// ======================================================================
    public function getAll()
    {
        $col_header = Constant::$adminAll['col_header'];
        $col        = Constant::$adminAll['col'];
        $col_db     = Constant::$adminAll['col_db'];

        $manuscripts = Manuscript::selectColumns($col)
                            ->get();
 
        return array('data' => $manuscripts, 'col_header' => $col_header, 'col_db' => $col_db);
    }

    public function getDataRejected($user, $status)
    {
        $permissions = explode(',', $user->actor_no);
        
        $pattern    = ['status'=> $status];
         
        if(in_array(CHIEF_EDITOR, $permissions)|| in_array(MANAGING_EDITOR, $permissions)) {
            $col_header = Constant::$inRejected['col_header'];
            $col        = Constant::$inRejected['col'];
            $col_db     = Constant::$inRejected['col_db'];
            
        }
        else if(in_array(SECTION_EDITOR, $permissions)){
            $col_header = Constant::$inRejected['col_header'];
            $col        = Constant::$inRejected['col'];
            $col_db     = Constant::$inRejected['col_db'];
            $pattern['editor_id'] = $user->id;
        }

        else if(in_array(AUTHOR, $permissions)){
            $col_header = Constant::$inScreeningAuthor['col_header'];
            $col        = Constant::$inScreeningAuthor['col'];
            $col_db     = Constant::$inScreeningAuthor['col_db'];
            $pattern['author_id'] = $user->id;
        }

        
        $manuscripts = Manuscript::selectColumns($col)
                            ->with(['author' =>function($q){
                                $q->select('id','last_name','middle_name','first_name');
                            }])
                            ->with(['seEditor' => function($q){
                                $q->select('id', 'first_name');
                            }])
                            ->with(['editor' => function($q){
                                $q->select('id', 'first_name');
                            }])
                            ->with(['editorManuscript' =>function($q){
                                $q->select('id','stage','loop','delivery_at','decide');
                            }])  
                            ->CheckWhere($pattern)                       
                            ->get();
        
        $manuscripts->each(function ($manuscript) {
            
            $manuscript->fullname = $manuscript->author->last_name.' '. $manuscript->author->middle_name.' '. $manuscript->author->first_name;
            empty($manuscript->editor) ? null : $manuscript->editor_name = $manuscript->editor->first_name;
            $manuscript->send_at = date("d/m/Y", strtotime($manuscript->send_at));
            empty($manuscript->editorManuscript)? null: $manuscript->process = $manuscript->editorManuscript->stage.' - '.$manuscript->editorManuscript->loop;
            empty($manuscript->seEditor)? null: $manuscript->section_editor_name = $manuscript->seEditor->first_name;
            empty($manuscript->editorManuscript) ? null : $manuscript->delivery_at = date("d/m/Y", strtotime($manuscript->editorManuscript->delivery_at));
            empty($manuscript->editorManuscript)? null:  $manuscript->decide = $manuscript->editorManuscript->decide;
        });
    
        return array('data' => $manuscripts, 'col_header' => $col_header, 'col_db' => $col_db);

    }

//=======================================================================
// hàm dùng để lấy data cho trang http://..../admin/manuscript/reviewer
// các biến được sử dụng trong hàm
// view chỉ dùng cho 'nhà phản biện'
// $col        : các columns cần lấy ra 
// $col_header : tiêu đề của bảng hiển thị
// $key        : tên columns
// ======================================================================
    public static function getDataReviewer($user,$status)
    {
        $col_header = Constant::$reviewer['col_header'];
        $col        = Constant::$reviewer['col'];
        $col_db     = Constant::$reviewer['col_db'];

        $manuscripts = Manuscript::where('status', '=', $status)
                            ->selectColumns($col)
                            ->with(['editorManuscript' =>function($q){
                                $q->select('id','loop','delivery_at','decide','section_editor_decide');
                            }])
                            ->get();
                         
        $manuscripts->each(function ($manuscript) {
            $manuscript->delivery_at = date("d/m/Y", strtotime($manuscript->delivery_at));
            $manuscript->process = $manuscript->status;
            $manuscript->section_editor_decide = $manuscript->editorManuscript->section_editor_decide;
            $manuscript->decide = $manuscript->editorManuscript->decide;
        });
        return array('data' => $manuscripts, 'col_header' => $col_header, 'col_db' => $col_db);

    }
//=======================================================================
// hàm dùng để lấy data cho trang http://..../admin/manuscript/published
// các biến được sử dụng trong hàm
// $col        : các columns cần lấy ra 
// $col_header : tiêu đề của bảng hiển thị
// $key        : tên columns
// ======================================================================

    public static function getDataPublished($user,$status)
    {
        $col_header = Constant::$auther_public_view['col_header'];
        $col        = Constant::$auther_public_view['manuscripts'];
        $col_db     = Constant::$auther_public_view['col_db'];
        $col_db1    = Constant::$auther_public_view['journal'];

        $manuscripts = Manuscript::where('status', '=', $status)
                            ->selectColumns($col)
                            ->with(['journalManuscriptPublish' =>function($q) use ($col_db1){
                                $q->select($col_db1);
                            }])
                            ->get();

        $manuscripts->each(function ($manuscript) {
            if($manuscript->journalManuscriptPublish)
            {
                $manuscript->journal_name = $manuscript->journalManuscriptPublish->name;
                $manuscript->num          = $manuscript->journalManuscriptPublish->num;
                $manuscript->publish_at   = $manuscript->journalManuscriptPublish->publish_at;
            }
            
            $manuscript->send_at      = date("d/m/Y", strtotime($manuscript->send_at));
        });
        return array('data' => $manuscripts, 'col_header' => $col_header, 'col_db' => $col_db);
    }

    public function getDataRejectedReview($user, $status)
    {
   
        $pattern    = ['status'=> $status, 'editor_id' => $user->id];
        $col_header = Constant::$rejectedReview['col_header'];
        $col        = Constant::$rejectedReview['col'];
        $col_db     = Constant::$rejectedReview['col_db'];

        $manuscripts = Manuscript::selectColumns($col)
                            ->with(['editorManuscript' =>function($q){
                                $q->select('id','delivery_at','created_at');
                            }])  
                            ->CheckWhere($pattern)                       
                            ->get();
        
        $manuscripts->each(function ($manuscript) {
            empty($manuscript->editorManuscript) ? null : $manuscript->delivery_at = date("d/m/Y", strtotime($manuscript->editorManuscript->delivery_at));
            empty($manuscript->editorManuscript) ? null : $manuscript->time_response = date("d/m/Y", strtotime($manuscript->editorManuscript->created_at));
        });

        return array('data' => $manuscripts, 'col_header' => $col_header, 'col_db' => $col_db);

    }

// test ================================================================================================


    public static function getDataInReview($user, $status) 
    {
        $permissions = explode(',', $user->actor_no);

        $manuscripts = Manuscript::status($status)
                                    ->with(['author' => function($query) use($user){
                                        $query->select('id', 'last_name');
                                    }])
                                    ->with(['editor' => function($q){
                                        $q->select('id', 'last_name');
                                    }])
                                    ->with(['editorManuscript' =>function($q){
                                        $q->select('id','loop','delivery_at','decide', 'section_editor_decide');
                                    }])
                                    ;

        if(in_array(CHIEF_EDITOR, $permissions)) 
        {
            $col_header = Constant::$in_review_chief_editor['col_header'];
            $col        = Constant::$in_review_chief_editor['col'];  
            $col_db     = Constant::$in_review_chief_editor['col_db'];

            $manuscripts  = $manuscripts->selectColumns($col)
                                    ->with(['seEditor' => function($q){
                                        $q->select('id', 'last_name');
                                    }])
                                    ->get();
            
            $manuscripts->each(function ($manuscript) {
                if($manuscript->editorManuscript)
                {
                    $manuscript->round_no_review = 'Bình luận vòng ' . $manuscript->editorManuscript->loop;
                    empty($manuscript->editor->last_name) ? null : $manuscript->reviewer = $manuscript->editor->last_name;
                }
                
                if($manuscript->author)
                    $manuscript->last_name = $manuscript->author->last_name;

                if($manuscript->seEditor)
                    empty($manuscript->seEditor->last_name) ? null : $manuscript->section_editor = $manuscript->seEditor->last_name;

                $manuscript->send_at = date("d/m/Y", strtotime($manuscript->send_at));
                empty($manuscript->chief_decide) ? null : $manuscript->round_decide_chief_editor = Constant::$chief_decide[$manuscript->chief_decide];
                empty($manuscript->is_chief_review) ? null : $manuscript->notify_chief_editor = Constant::$notify_chief_editor[$manuscript->is_chief_review];
            });

        } 
        else if(in_array(SECTION_EDITOR, $permissions)) 
        {

            $col_header = Constant::$in_review_section_editor['col_header'];
            $col        = Constant::$in_review_section_editor['col'];  
            $col_db     = Constant::$in_review_section_editor['col_db'];

            $manuscripts = $manuscripts->selectColumns($col)->get();
                                
            $manuscripts->each(function ($manuscript) {
                if($manuscript->editorManuscript)
                    $manuscript->round_no_review = 'Bình luận vòng ' . $manuscript->editorManuscript->loop;

                if($manuscript->editor)
                    empty($manuscript->editor->last_name) ? null : $manuscript->reviewer = $manuscript->editor->last_name;

                if($manuscript->author)
                    $manuscript->last_name = $manuscript->author->last_name;
                
                $manuscript->send_at = date("d/m/Y", strtotime($manuscript->send_at));
                empty($manuscript->chief_decide) ? null : $manuscript->round_decide_chief_editor = Constant::$chief_decide[$manuscript->chief_decide];
                empty($manuscript->is_chief_review) ? null : $manuscript->notify_chief_editor = Constant::$notify_chief_editor[$manuscript->is_chief_review];
            });

        } 
        else if(in_array(MANAGING_EDITOR, $permissions)) 
        {
            $col_header = Constant::$in_review_manager_editor['col_header'];
            $col        = Constant::$in_review_manager_editor['col'];  
            $col_db     = Constant::$in_review_manager_editor['col_db'];

            $manuscripts = $manuscripts->selectColumns($col)
                                    ->with(['seEditor' => function($q){
                                        $q->select('id', 'last_name');
                                    }])
                                    ->get();
                                
            $manuscripts->each(function ($manuscript) {
                if($manuscript->editorManuscript)
                    $manuscript->round_no_review = 'Bình luận vòng ' . $manuscript->editorManuscript->loop;

                if($manuscript->editor)
                    empty($manuscript->editor->last_name) ? null : $manuscript->reviewer = $manuscript->editor->last_name;
                
                if($manuscript->author)
                    $manuscript->last_name = $manuscript->author->last_name;
                if($manuscript->seEditor)
                    empty($manuscript->seEditor->last_name) ? null : $manuscript->section_editor = $manuscript->seEditor->last_name;
                
                $manuscript->send_at = date("d/m/Y", strtotime($manuscript->send_at));
                empty($manuscript->chief_decide) ? null : $manuscript->round_decide_chief_editor = Constant::$chief_decide[$manuscript->chief_decide];
                empty($manuscript->is_chief_review) ? null : $manuscript->notify_chief_editor = Constant::$notify_chief_editor[$manuscript->is_chief_review];
            });

        } 
        else if (in_array(AUTHOR, $permissions)) 
        {
            $col_header = Constant::$in_review_author['col_header'];
            $col        = Constant::$in_review_author['col'];
            $col_db     = Constant::$in_review_author['col_db'];

            $manuscripts =  $manuscripts->selectColumns($col)
                                    ->whereHas('author', function($q) use($user){
                                        $q->where('id', $user->id);
                                    })
                                    ->get();

            $manuscripts->each(function ($manuscript) {
                // dd($manuscript);
                if($manuscript->editorManuscript)
                {
                    $manuscript->round_no_review = 'Bình luận vòng ' . $manuscript->editorManuscript->loop;
                    empty($manuscript->editorManuscript->decide) ? null : $manuscript->round_decide_editor = Constant::$editor_decide[$manuscript->editorManuscript->decide];
                }
                
                if($manuscript->author)
                    $manuscript->last_name = $manuscript->author->last_name;
                
                $manuscript->send_at = date("d/m/Y", strtotime($manuscript->send_at));
            });
        } 
        else
            abort(333);
            // return array('data' => [], 'col_header' => [], 'col_db' => []);

        // dd($manuscripts);

        return array('data' => $manuscripts, 'col_header' => $col_header, 'col_db' => $col_db);
    }

    public static function getDataWithDrawn($user, $status)
    {
        $permissions = explode(',', $user->actor_no);

        $manuscripts = Manuscript::status($status)
                                    ->with(['author' => function($q) use($user){
                                        $q->select('id', 'last_name');
                                    }])
                                    ->with(['editor' => function($q){
                                        $q->select('id', 'last_name');
                                    }])
                                    ->with(['editorManuscript' =>function($q){
                                        $q->select('id','loop','delivery_at','decide', 'section_editor_decide');
                                    }]);
        
        $col_header = Constant::$withdrawn['col_header'];
        $col        = Constant::$withdrawn['col'];
        $col_db     = Constant::$withdrawn['col_db'];
        
        if(in_array(AUTHOR, $permissions)) 
        {
            $manuscripts =  $manuscripts->whereHas('author', function($q) use($user){
                                        $q->where('id', $user->id);
                                    })
                                    ->get();
        } 
        else if(in_array(ADMIN, $permissions))
        {
            abort(333);
        }
        else
        {
            $manuscripts =  $manuscripts->get();
        }
        
        $manuscripts->each(function ($manuscript) {
            $manuscript->send_at = date("d/m/Y", strtotime($manuscript->send_at));
            empty($manuscript->chief_decide) ? '-' : $manuscript->editor_chief_decide = Constant::$chief_decide[$manuscript->chief_decide];

            if($manuscript->editorManuscript){
                $manuscript->round_no_review = 'Vòng ' . $manuscript->editorManuscript->loop;
                $manuscript->withdrawn_at = date("d/m/Y", strtotime($manuscript->editorManuscript->update_at));
            }

            if($manuscript->editor)
                empty($manuscript->editor->decide) ? '-' : $manuscript->editor_decide = Constant::$editor_decide[$manuscript->editor->decide];

            if($manuscript->author)
                empty($manuscript->author->last_name) ? '-' : $manuscript->last_name = $manuscript->author->last_name;
        });

        // dd($manuscripts);
        return array('data' => $manuscripts, 'col_header' => $col_header, 'col_db' => $col_db);
    }

    public static function getDataWaitReview($user, $status)
    {   
        $permissions = explode(',', $user->actor_no);

        if(!in_array(REVIEWER, $permissions))
            abort(333);
            // return array('data' => [], 'col_header' => [], 'col_db' => []);

        $col_header = Constant::$wait_review['col_header'];
        $col        = Constant::$wait_review['col'];
        $col_db     = Constant::$wait_review['col_db'];

        $manuscripts = Manuscript::where('status', '=', $status)
                                    ->where('editor_id', '=', $user->id)
                                    ->with('author')
                                    ->with(['editorManuscript' =>function($q){
                                        $q->select('id','loop','delivery_at','decide', 'deadline_at');
                                    }])
                                    ->get();
                                    
        $manuscripts->each(function ($manuscript) {
            if($manuscript->editorManuscript){
                $manuscript->round_no_review = 'Vòng ' . $manuscript->editorManuscript->loop;
                $manuscript->delivery_at = date("d/m/Y", strtotime($manuscript->editorManuscript->delivery_at));
                $manuscript->deadline_at = date("d/m/Y", strtotime($manuscript->editorManuscript->deadline_at));
                empty($manuscript->editorManuscript->decide) ? '-' : $manuscript->decide = Constant::$reviewer_decide[$manuscript->editorManuscript->decide];
            }
        });

        return array('data' => $manuscripts, 'col_header' => $col_header, 'col_db' => $col_db);
    }

    public static function getDataAll($user) 
    {   
        $permissions = explode(',', $user->actor_no);

        $col_header = Constant::$all['col_header'];
        $col        = Constant::$all['col'];
        $col_db     = Constant::$all['col_db'];

        $manuscripts = Manuscript::with(['editorManuscript' =>function($q){
                                        $q->select('id', 'loop', 'stage');
                                    }])
                                    ->with('author');
                                    
        if(in_array(AUTHOR, $permissions)) 
        {
            $manuscripts =  $manuscripts
                                    ->whereHas('author', function($q) use($user){
                                        $q->where('id', $user->id);
                                    })
                                    ->get();
        } 
        else if(in_array(CHIEF_EDITOR, $permissions) || in_array(MANAGING_EDITOR, $permissions))
        {
            $manuscripts =  $manuscripts->get();
        } 
        else if(in_array(SECTION_EDITOR, $permissions))
        {
            $manuscripts =  $manuscripts
                                ->whereHas('seEditor', function($q) use($user){
                                        $q->where('id', $user->id);
                                })                                
                                ->get();
        } 
        else if(in_array(COPY_EDITOR, $permissions) || in_array(SCREENING_EDITOR, $permissions))
        {
            // COPY_EDITOR and SCREENING_EDITOR
            $manuscripts =  $manuscripts
                                ->whereHas('editor', function($q) use($user){
                                        $q->where('id', $user->id);
                                }) 
                                ->get();
        }
        else
        {
            // dd('dfkla;s');
            abort(333);
            // return array('data' => $manuscripts, 'col_header' => $col_header, 'col_db' => $col_db);
        }
            

        $manuscripts->each(function ($manuscript) {
            $manuscript->send_at = date("d/m/Y", strtotime($manuscript->send_at));

            if($manuscript->editorManuscript){
                $manuscript->last_round= 'Vòng ' . $manuscript->editorManuscript->loop;
                $manuscript->process = empty($manuscript->editorManuscript->stage) ? '-' : Constant::$process[$manuscript->editorManuscript->stage];
            }

            if($manuscript->author)
                empty($manuscript->author->last_name) ? '-' : $manuscript->last_name = $manuscript->author->last_name;
        });

        return array('data' => $manuscripts, 'col_header' => $col_header, 'col_db' => $col_db);
    }

    //=======================================================================
// hàm dùng để lấy data cho trang http://..../admin/manuscript/published
// các biến được sử dụng trong hàm
// $col        : các columns cần lấy ra 
// $col_header : tiêu đề của bảng hiển thị
// $col_db        : tên columns
// ======================================================================    

    public static function getDataInScreening($user, $status)
    {
        $permissions = explode(',', $user->actor_no);
        
        $pattern    = ['status'=> $status];
         
        if(in_array(CHIEF_EDITOR, $permissions)|| in_array(MANAGING_EDITOR, $permissions)) {
            $col_header = Constant::$inScreeningChief['col_header'];
            $col        = Constant::$inScreeningChief['col'];
            $col_db     = Constant::$inScreeningChief['col_db'];
            
        }
        else if(in_array(SCREENING_EDITOR, $permissions)){
            $col_header = Constant::$inScreeningScreengEditor['col_header'];
            $col        = Constant::$inScreeningScreengEditor['col'];
            $col_db     = Constant::$inScreeningScreengEditor['col_db'];
            $pattern['editor_id'] = $user->id;
        }

        else if(in_array(AUTHOR, $permissions)){
            $col_header = Constant::$inScreeningAuthor['col_header'];
            $col        = Constant::$inScreeningAuthor['col'];
            $col_db     = Constant::$inScreeningAuthor['col_db'];
            $pattern['author_id'] = $user->id;
        }

        
        $manuscripts = Manuscript::selectColumns($col)
                            ->with(['author' =>function($q){
                                $q->select('id','last_name','middle_name','first_name');
                            }])
                            ->with(['editor' => function($q){
                                $q->select('id', 'first_name');
                            }])
                            ->with(['editorManuscript' =>function($q){
                                $q->select('id','stage','loop','delivery_at','decide');
                            }])  
                            ->CheckWhere($pattern)                       
                            ->get();
        
        $manuscripts->each(function ($manuscript) {
            
            $manuscript->fullname = $manuscript->author->last_name.' '. $manuscript->author->middle_name.' '. $manuscript->author->first_name;
            empty($manuscript->editor) ? null : $manuscript->editor_name = $manuscript->editor->first_name;
            $manuscript->send_at = date("d/m/Y", strtotime($manuscript->send_at));
            empty($manuscript->editorManuscript)? null: $manuscript->process = Constant::$stage[$manuscript->editorManuscript->stage].' vòng'.$manuscript->editorManuscript->loop;
            empty($manuscript->editorManuscript) ? null : $manuscript->delivery_at = date("d/m/Y", strtotime($manuscript->editorManuscript->delivery_at));
            empty($manuscript->editorManuscript)? null:  $manuscript->decide = $manuscript->editorManuscript->decide;
        });
    
        return array('data' => $manuscripts, 'col_header' => $col_header, 'col_db' => $col_db);
    }

    public function getDataReport($start, $end, $status)
    {
        $now = time();
        $in_month = $now - 24*3600*30;   // default: 1 month
        if(empty($start))
        {
            $start = date('d/m/Y', $in_month);
            $obj_start = date_create_from_format("Y/m/d", date('Y/m/d', $in_month));
        }
        else
        {
            $obj_start = date_create_from_format("d/m/Y", Input::get('start'));
        }

        if(empty($end))
        {
            $end = date('d/m/Y', $now);
            $obj_end = date_create_from_format("Y/m/d", date('Y/m/d', $now));
        }
        else
        {
            $obj_end = date_create_from_format("d/m/Y", Input::get('end'));
        }

        $permissions = explode(',', \Auth::user()->actor_no);

        // dd($obj_start);
        // dd($obj_end);
        switch ($status) {
            case REPORT_REJECTED:  //admin/report/rejected
                $count_manu = $this->getDataReportRejected($obj_start, $obj_end, $permissions);

                break;
            
            case REPORT_SUBMITED: //admin/report/submited
                $count_manu = $this->getDataReportSubmited($obj_start, $obj_end, $permissions, SCREENING);

                break;

            case REPORT_PUBLISH_IN_YEAR: //admin/report/publish
                $in_year = $now - 24*3600*365;    // 1 year

                if(Input::get('start'))
                {   
                    $obj_start = date_create_from_format("d/m/Y", Input::get('start'));
                }
                else
                {
                    $start = date('d/m/Y', $in_year);
                    $obj_start = date_create_from_format("Y/m/d", date('Y/m/d', $in_year));
                }

                $count_manu = $this->getDataReportPublishInYear($obj_start, $obj_end, $permissions, SCREENING);

                break;

            case REPORT_REVIEW_LOOP:  //admin/report/rejected
                $count_manu = $this->getDataReportReviewLoop($obj_start, $obj_end, $permissions);

                break;

            case REPORT_WITHDRAWN:  //admin/report/withdraw
                $count_manu = $this->getDataReportWithDrawn($obj_start, $obj_end, $permissions);

                break;

            case REPORT_RATIO_REJECT:  //admin/report/ratio_rejected
                $count_manu = $this->getDataReportRatioRejected($obj_start, $obj_end, $permissions);

                break;

            case REPORT_PUBLISHED_DELINQUENT:  //admin/report/published_delinquent
                $count_manu = $this->getDataJournalPublishedDelinquent($obj_start, $obj_end, $permissions);

                break;

            case REPORT_JOURNAL_IN_YEAR:  //admin/report/published_delinquent
                $in_year = $now - 24*3600*365;    // 1 year

                if(Input::get('start'))
                {   
                    $obj_start = date_create_from_format("d/m/Y", Input::get('start'));
                }
                else
                {
                    $start = date('d/m/Y', $in_year);
                    $obj_start = date_create_from_format("Y/m/d", date('Y/m/d', $in_year));
                }
                $count_manu = $this->showJournalPublishInYear($obj_start, $obj_end, $permissions);

                break;

            case REPORT_REVIEW_TIME:  //admin/report/published_delinquent
                // dump(date_create_from_format("d/m/Y", Input::get('end')));
                // dump($start, $end, $obj_start, $obj_end);
                $count_manu = $this->showReportReviewTime($obj_start, $obj_end, $permissions);

                break;

            default:
                
                break;
        }
        $data = ['start' => $start, 'end' => $end, 'count_manu' => $count_manu];

        return $data;
    }

    public function whereHasUserId($query)
    {
        if(!$query)    

            return null;

        return $query = $query
                    ->whereHas('author', function($q)
                    {
                        $q->orWhere('id', \Auth::user()->id);
                    });
    }

    public function orWhereQuery($query, $field_name, $where_array)
    {
        if(!$query)    

            return null;
        // dd('dslajl');
        return $query = $query->where(function($q) use($field_name, $where_array)
                        {
                            $total = count($where_array);
                            if ($total > 0) 
                            {
                                $q = $q->where($field_name, $where_array[0]);
                                for($i = 1; $i < $total; $i++){ 
                                    $q = $q->orWhere($field_name, $where_array[$i]);
                                }
                            }
                            // ($total > 0) ? $q = $q->where($field_name, $where_array[0]) : null;
                        });
    }

    public function relationEditorManuscriptByStage($query, $stage)
    {
        $query = $query->whereHas('editorManuscripts', function($q) use($stage)
        {
            $q->where('stage', $stage);
        });
        
        return $query;
    }

    public function whereBetweenDatetime($query, $field_name, $start_time, $end_time)
    {
        if(!$query)

            return null;

        return $query->where($field_name, '>=', $start_time)
                    ->where($field_name, '<=', $end_time);
    }

    public function getCountRejectedManuscript($start, $end, $status = array(REJECTED), $stage = null)
    {
        $query = Manuscript::with('editorManuscripts');

        // $count = DB::table('manuscripts');
        if ($stage) {
            $query = $this->relationEditorManuscriptByStage($query, $stage);
        }

        $query = $this->whereBetweenDatetime($query, 'updated_at', $start, $end );

        $query = $this->orWhereQuery($query, 'status', $status);

        return $query;
    }

    public function getCountWithdrawnManuscript($start, $end, $status = array(WITHDRAWN), $stage = null)
    {
        $query = Manuscript::with('editorManuscripts');

        if($stage)
           $query = $this->relationEditorManuscriptByStage($query, $stage);
        
        $query = $this->whereBetweenDatetime($query, 'updated_at', $start, $end );

        $query = $this->orWhereQuery($query, 'status', $status);

        return $query;
    }

    public function getCountSubmitedManuscript($start, $end)
    {
        $query = Manuscript::where('status', '<>', UNSUBMIT);
        $query = $this->whereBetweenDatetime($query, 'created_at', $start, $end);
        
        return $query;
    }

    public function getDataReportRejected($start, $end, $permissions, $status = array(REJECTED))//array(REJECT, REVIEW_REJECT))
    {
        // Bản thảo bị từ chối
        // Manuscript Table
        // date_base = created_at  (between $start -> $end)
        // status = REJECT
        // user_id = $user->id (optional)

        $count = $this->getCountRejectedManuscript($start, $end, $status, null);
        
        if(in_array(AUTHOR, $permissions) and $count != null)
            $count = $this->whereHasUserId($count);

        return ($count) ? $count->count() : '0';
    }

    public function getDataReportSubmited($start, $end, $permissions, $stage)
    {
        // Tổng số bản thảo đã gửi
        // Mỗi bản thảo được tạo là 1 lần gửi, gửi nhiều lần 1 bản thảo vẫn chỉ là 1 lần gửi
        // Manuscript Table
        // date_base = created_at  (between $start -> $end)
        // status != UNSUBMIT
        // user_id = $user->id (optional)

        $count = $this->getCountSubmitedManuscript($start, $end);

        if(in_array(AUTHOR, $permissions) and $count != null)
            $count = $this->whereHasUserId($count);

        return ($count) ? $count->count() : '0';
    }

    public function getDataReportPublishInYear($start, $end, $permissions, $stage)
    {   
        // Số bản thảo xuất bản trong vòng 1 năm
        // Manuscript Table
        // status = PUBLISHED(Xuất bản)
        // date_base = updated_at (between $start -> $end)
        // user_id = $user->id (optional)

        $count = Manuscript::whereStatus(PUBLISHED);
        $count = $this->whereBetweenDatetime($count, 'updated_at', $start, $end);
                        
        if(in_array(AUTHOR, $permissions))
            $count = $this->whereHasUserId($count);

        return ($count) ? $count->count() : '0';
    }

    public function getDataReportReviewLoop($start, $end, $permissions)
    {
        // Số vòng phản biện bình quân
        // Tổng Số vòng bình duyệt có phản biện / (Tổng Số bản thảo đang trong tiến trình bình duyệt + đã qua tiến trình bình duyệt)
        $count_has_review = Manuscript::with('editorManuscripts')
                        ->whereHas('editorManuscripts', function($q) use($start, $end)
                        {
                            $q->where('stage', REVIEWING)
                                ->where('decide', REVIEW_ACCEPT);
                            $q = $this->whereBetweenDatetime($q, 'created_at', $start, $end);
                        });

        $count_total = Manuscript::with('editorManuscript')
                        ->whereHas('editorManuscript', function($q) use($start, $end)
                        {
                            $q = $this->orWhereQuery($q, 'stage', [PUBLISHING, EDITING, REVIEWING]);
                            $q = $this->whereBetweenDatetime($q, 'created_at', $start, $end);
                        });

        if(in_array(AUTHOR, $permissions))
        {
            $count_has_review = $this->whereHasUserId($count_has_review);
            $count_total = $this->whereHasUserId($count_total);
        }

        $total = ($count_total) ? $count_total->count() : 0 ;
        $ratio = ($total > 0) ? $count_has_review->count()/$total : 0;

        return (number_format($ratio, 3, '.', ''));
    }

    public function getDataReportWithDrawn($start, $end, $permissions)
    {   
        // Số bản thảo rút nộp
        // Manuscript Table
        // status = WITHDRAWN 
        // date_base = updated_at (between $start -> $end)
        // user_id = $user->id (optional)

        $count = $this->getCountWithdrawnManuscript($start, $end);

        if(in_array(AUTHOR, $permissions))
            $count = $this->whereHasUserId($count);

        return ($count) ? $count->count() : '0';
    }

    public function getDataReportRatioRejected($start, $end, $permissions)
    {   
        // Tỷ lệ từ chối vòng sơ loại = 
        // Tổng bản thảo nhận bị “Từ chối” vòng sơ loại / (Tổng bản thảo gửi - Tổng bản thảo xin rút nộp vòng sơ loại)
        // Tổng bản thảo nhận bị “Từ chối” vòng bình duyệt / (Tổng bản thảo gửi - Tổng bản thảo xin rút nộp vòng bình duyệt)

        // Limit time: $start -> $end
        // Tổng bản thảo gửi trong khoảng thời gian
        // Tổng bản thảo nhận bị “Từ chối” vòng sơ loại 
        // Tổng bản thảo nhận bị “Từ chối" vòng Bình duyệt 
        // Tổng bản thảo xin rút nộp vòng sơ loại
        // Tổng bản thảo xin rút nộp vòng bình duyệt

        // Tổng bản thảo gửi trong khoảng thời gian
        $total_submited = $this->getCountSubmitedManuscript($start, $end);

        // Từ chối sơ loại
        $rejected_screen = $this->getCountRejectedManuscript($start, $end, [REJECTED], [SCREENING]);

        // Từ chối bình duyệt
        $rejected_review = $this->getCountRejectedManuscript($start, $end, [REJECTED], [REVIEWING]);

        // Tổng bản thảo xin rút nộp vòng bình duyệt
        $withdrawn_review = $this->getCountWithdrawnManuscript($start, $end, [WITHDRAWN],[REVIEWING]);

        // Tổng bản thảo xin rút nộp vòng bình duyệt
        $withdrawn_screen = $this->getCountWithdrawnManuscript($start, $end, [WITHDRAWN],[SCREENING]);

        if(in_array(AUTHOR, $permissions))
        {
            $total_submited = ($total_submited) ? $this->whereHasUserId($total_submited) : 0;
            $rejected_review = ($rejected_review) ? $this->whereHasUserId($rejected_review) : 0;
            $rejected_screen = ($rejected_screen) ? $this->whereHasUserId($rejected_screen) : 0;
            $withdrawn_review = ($withdrawn_review) ? $this->whereHasUserId($withdrawn_review) : 0;
            $withdrawn_screen = ($withdrawn_screen) ? $this->whereHasUserId($withdrawn_screen) : 0;
        }

        // number of manuscripts
        $count_total = $total_submited->count();
        $count_rejected_review = $rejected_review->count();
        $count_rejected_screen = $rejected_screen->count();
        $count_withdrawn_review = $withdrawn_review->count();
        $count_withdrawn_screen = $withdrawn_screen->count();

        // check null 
        $actual_total_screen = ($count_total - $count_withdrawn_screen);
        $actual_total_review = ($count_total - $count_withdrawn_review);
        $actual_total = ($count_total - $count_withdrawn_review - $count_withdrawn_review);

        $ratio_reject_review = ($actual_total_review == 0) ? 0 : ($count_rejected_review) / $actual_total_review;
        $ratio_reject_screen = ($actual_total_screen == 0) ? 0 : ($count_rejected_review) / $actual_total_screen;
        $ratio_total = ($actual_total == 0) ? 0 : ($count_rejected_screen + $count_rejected_review) / $actual_total;

        // combine data
        $arr_data = [
                        'data'      => number_format($ratio_total, 3, '.', ''), 
                        'screen'    => number_format($ratio_reject_screen, 3, '.', ''), 
                        'review'    => number_format($ratio_reject_review, 3, '.', '')
                    ];

        return $arr_data;
    }

    public function getDataJournalPublishedDelinquent($start, $end)
    {   
        // Tổng số tạp chí xuất bản không đúng kỳ hạn theo năm
        // Journal Table
        // publish_at < expect_publish_at
        // date_base = created_at (between $start -> $end)

        $count = Journal::whereRaw(' (publish_at < expect_publish_at) ')
                    ->where(function($q) use($start, $end){
                        $q = $this->whereBetweenDatetime($q, 'updated_at', $start, $end);
                    });

        return $count->count();
    }

    public function showJournalPublishInYear($start, $end, $permissions)
    {   
        // Số tạp chí xuất bản trong năm
        // Journal Table
        // date_base = publish_at (between $start -> $end)

        $count = Journal::where(function($q) use($start, $end){
                        $q = $this->whereBetweenDatetime($q, 'publish_at', $start, $end);
                    });
        
        return ($count) ? $count->count() : '0';
    }

    public function showReportReviewTime($start, $end, $permissions)
    {   
        // Thời gian phản biện bình quân
        // Editor Manuscript Table
        // stage = REVIEWING 
        // date_base = updated_at (between $start -> $end)
        // user_id = $user->id (optional)

        $review_time = Manuscript::selectColumns('*')
                        ->with('editorManuscripts')
                        ->whereHas('editorManuscripts', function($q) use($start, $end)
                        {
                            $q->where('stage', REVIEWING);
                            $q = $this->whereBetweenDatetime($q, 'created_at', $start, $end);
                        })
                        ->get();

        $count = 0;
        $total_time = 0;
        foreach ($review_time as $value) {
            foreach ($value->editorManuscripts as $editor_value) {
                $count ++;
                $total_time += strtotime($editor_value['deadline_at']) - strtotime($editor_value['delivery_at']);
            }
        }

        $ratio = ($count != 0) ? $total_time / $count : 0;
        $ratio = $ratio / (3600*24);
        $ratio = number_format($ratio, 2, '.', '');

        return $ratio;
    }

    public function getColumnTable($process, $actor, $reviewer_list = false)
    {
        return [
            'data'             =>  $this->getDataTable($process, $actor, $reviewer_list),
            'col_header'       =>  Constant::$tableColumns[$process][$actor]['col_header'],
            'col_db'           =>  Constant::$tableColumns[$process][$actor]['col_result'],
        ];
    }

    public function getDataTable($process, $actor, $reviewer_list = false)
    {
        $col = Constant::$tableColumns[$process][$actor]['col_select'];
        $relate_cols = Constant::$tableColumns[$process][$actor]['col_relate'];
        $relates = $this->getRelate($process, $actor);

        $status = in_array($process, [WAIT_REVIEW, REVIEWED, REJECTED_REVIEW]) ? IN_REVIEW : $process;

        $data = $this->model->status($status)
                            ->actor($actor, $this->user->id, $reviewer_list)
                            ->select($col)
                            ->with($relates)->get();

        $data = $this->mergeRelateCol($relate_cols, $data);

        return $data;
    }

    public function mergeRelateCol($relate_cols, $data)
    {
        foreach ($data as $value) {
            foreach ($relate_cols as $relate => $col) {
                $property = $relate.'_'.$col;
                $value->$property = is_object($value->$relate) ? $value->$relate->$col : '';
            }
        }

        return $data;
    }

    public function getRelate($process, $actor)
    {
        $relates = Constant::$relateColSelect[$process][$actor];

        $result = array();
        foreach ($relates as $key => $value) {
            if ($key == 'editorManuscript' && $this->hasPermission(REVIEWER)) {
                $result[$key] = function($query) use ($value) {
                    $query->select($value)->where('user_id', $this->user->id);
                };
            } else {
                $result[$key] = function($query) use ($value) {
                    $query->select($value);
                };
            }
        }

        return $result;
    }


    public function uploadFile(){
        if(doUploadDocument()){

            return $_FILES["file"]["name"] . '/' . basename($_FILES["file"]["name"]);
        }

        return '';
    }

    public function uploadFileEditor($manu_id, $user_id, $file_type, $new_key_manu_id = null, $is_new = COPY_MANUSCRIPT_FILE){
        

        $new_key_manu_file_id = null;

        if($is_new == NEW_MANUSCRIPT_FILE)
        {
            // dd($manu_id, $user_id, $file_type, $new_key_manu_id , $is_new);
            // dump('NEW_MANUSCRIPT_FILE');
            // nếu là tạo mới manuscript file
            $new_manu = $this->createNewManuscriptFile($manu_id, $user_id, $file_type, NEW_MANUSCRIPT_FILE);
            $manu_id = $new_manu->manuscript_id;
            $new_key_manu_file_id = $new_manu->id;
        }
        else
        {
            // dd('COPY_MANUSCRIPT_FILE');
            // dump('COPY_MANUSCRIPT_FILE');
            // old file
            $new_manu = $this->createNewManuscriptFile($manu_id, $user_id, $file_type, COPY_MANUSCRIPT_FILE);

            // check null
            
        }

        if(!$_FILES)

            return false;

        if(doUploadDocument()){

            // Update Manuscript files with file type
            $this->saveManuscriptFiles($manu_id, $user_id, $new_key_manu_id, $file_type, $new_key_manu_file_id);

            //return path file if ok
            return $_FILES["file"]["name"] . '/' . basename($_FILES["file"]["name"]);
        }

        return '';
    }

    public function downloadFile($manu_file_id)
    {
        // Get full path in ManuscriptFiles table
        $manuFiles = ManuscriptFile::find($manu_file_id);

        // dd($manuFiles);
        
        $file_path = $manuFiles ? $manuFiles->name : '';
        
        // Download File
        doDownloadFileWithFullPath(public_path() . FILE_PATH . '/' . $file_path);

        return true;
    }

    public function createNewManuscriptFile($manu_id, $user_id, $file_type, $is_new)
    {
        if($is_new == NEW_MANUSCRIPT_FILE)
        {
            $this->newManuscriptFile($manu_id, $user_id, $file_type);
        }
        else
        {
            $manu_file = new ManuscriptFile;
            $old_manu = ManuscriptFile::where('manuscript_id', $manu_id)
                                    ->where('user_id', $user_id)
                                    ->first();
            if(!$old_manu)
            {
                return $this->newManuscriptFile($manu_id, $user_id, $file_type);
            }
            $manu_file->fill($old_manu->toArray());
            $manu_file->type = $file_type;
            $manu_file->save();
        }
         
        return $manu_file;
    }

    public function newManuscriptFile($manu_id, $user_id, $file_type)
    {
        $manu_file = new ManuscriptFile;
        $manu_file->manuscript_id = $manu_id;
        $manu_file->user_id = $user_id;
        $manu_file->type = $file_type;
        $manu_file->save();

        return $manu_file;
    }

    public function restoreStatusListbox($manuscripts)
    {

        $manuscripts->keyword_vi = explode(',', $manuscripts->keyword_vi);
        $manuscripts->keyword_en = explode(',', $manuscripts->keyword_en);

        return $manuscripts;
    }
}
