<?php namespace App\Lib\Prototype\DBClasses\Eloquent;

use Illuminate\Contracts\Auth\Guard;
use App\Lib\Prototype\BaseClasses\AbstractEloquentRepository;
use App\Lib\Prototype\Interfaces\ManuscriptInterface;
use App\Lib\Prototype\Interfaces\UserInterface;
use App\Lib\Prototype\Interfaces\EditorManuscriptInterface;
use App\Manuscript;
use App\Journal;
use App\ManuscriptFile;
use App\EditorManuscript;
use App\Keyword;
use App\KeywordManuscript;
use App\User;
use URL;
use Input;
use Session;
use Constant;
use Redirect;
use DateTime;
use DB;
use App\Lib\Prototype\Common\traitJournal;

// use ConstantArray;


class EloquentManuscriptRepository extends AbstractEloquentRepository implements ManuscriptInterface
{
    use traitJournal;

    protected $editor_model;
    protected $user_repo;
    protected $journal_model;

    public function __construct(Manuscript $model, EditorManuscriptInterface $editor_model, UserInterface $user_repo, Journal $journal_model)
    {
        $this->model = $model;
        $this->editor_model = $editor_model;
        $this->journal_model = $journal_model;
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
        $key_manu = $manuscript->id;	//DB::getPdo()->lastInsertId();

        //Constant::$keyword_type[VI]
        $this->saveKeywords(Input::get('keyword_vi'), Input::get('keyword_en'), $key_manu, $id);

        // save files information
        $this->saveManuscriptFiles($key_manu, $this->user->id, AUTHOR_FILE);

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

    // public function saveManuscriptFiles($manu_id, $user_id, $new_key_manu_id = null, $type = null, $new_key_manu_file_id = null)
    public function saveManuscriptFiles($manu_id, $user_id, $type = null)
    {
        if(!Session::has(FILE_UPLOAD_SESSION))
            
            return null;

        $manu_file = null;
        if($manu_id)
        {   
            // Get data từ db
            $manu_file = ManuscriptFile::where('user_id', $user_id)->where('manuscript_id', $manu_id)
                                        ->orderBy('updated_at', 'desc')->first(); 
        }

        // check exist
        if(!$manu_file)
        {
            $manu_file = $this->createNewManuscriptFile($manu_id, $user_id, $type, 0);
        }
        
        // TODO: need delete old file (soft delete or hard delete ?)
        //

        $manu_file->name = Session::get(FILE_UPLOAD_SESSION);
        $manu_file->total_page = Session::has(FILE_UPLOAD_TOTAL_PAGE) ? Session::get(FILE_UPLOAD_TOTAL_PAGE) : 0;
        $manu_file->extension = Session::has(FILE_UPLOAD_EXTENSION) ? Session::get(FILE_UPLOAD_EXTENSION) : '';
        $manu_file->save();

        return $manu_file;
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

    public function getManagingEditorViewData($manuscript_id)
    {
        $data = $this->getViewDataById($manuscript_id);

        //get list invite reviewers
        $data['reviewed_list'] = $this->user_repo->getByIds($data['manuscript']->reviewer_ids);
        //get list rejected reviewers
        $data['reject_list'] = $this->user_repo->getByIds($data['manuscript']->reject_reviewer_ids);
        //get list invite reviewer
        $data['invite_list'] = $this->user_repo->getByIds($data['manuscript']->invite_reviewer_ids);

        $data['reviewers'] = $this->user_repo->getListIds(REVIEWER);
// dd($data, 'MANAGING_EDITOR');
        return $data;
    }

    public function getChiefViewData($manuscript_id)
    {
        $data = $this->getViewDataById($manuscript_id);
        $data['journals'] = $this->getUnpublishJournal();

        return $data;
    }

    public function getSectionEditorViewData($manuscript_id)
    {
        $data = $this->getViewDataById($manuscript_id);
        $data['view'] = 'manuscripts.editors.includes.inreview.section';

        if ($data['manuscript']->status == IN_EDITING) {
            $data['copy_editors'] = $this->user_repo->getListIds(COPY_EDITOR);
            $data['view'] = 'manuscripts.editors.includes.inediting.section';
        }

        return $data;
    }

    public function getCopyEditorViewData($manuscript_id)
    {
        $data = $this->getViewDataById($manuscript_id);

        if ($data['manuscript']->is_print_out) {
            $file_type = LAYOUT_PRINT_FILE;
            $data['label'] = 'Tải xuống bản thảo chế bản';
            $data['view'] = 'manuscripts.editors.includes.inediting.printout.copy';
        } elseif ($data['manuscript']->is_revise) {
            $file_type = REVISE_FILE;
            $data['label'] = 'Tải xuống bản thảo hiệu đính';
            $data['view'] = 'manuscripts.editors.includes.inediting.copy';
        } else {
            $file_type = $data['manuscript']->file_version;
            $data['layout_editors'] = $this->user_repo->getListIds(LAYOUT_EDITOR);
            $data['label'] = 'Tải xuống bản thảo';
            $data['view'] = 'manuscripts.editors.includes.inediting.copy';
        }

        $data['file_download'] = getFileByType($data['manuscript']->manuscriptFiles, $file_type);
        
        return $data;
    }

    public function getLayoutEditorViewData($manuscript_id)
    {
        $data = $this->getViewDataById($manuscript_id);

        if ($data['manuscript']->is_print_out) {
            $file_type = LAYOUT_PRINT_FILE;
            //Khi bản thảo đã chế bản, btv chế bản có thể xem các nhận xét bản bông
            $data['copyeditor_comment'] = $this->editor_model->getCommentsByEditorIds($data['manuscript']->current_editor_manuscript_id, 
                                                                                      $data['manuscript']->editor_id);
            $data['author_comment'] = $this->editor_model->getCommentsByEditorIds($data['manuscript']->current_editor_manuscript_id, 
                                                                                 $data['manuscript']->author_id);
        } else {
            $file_type = REVISE_FILE;
        }

        $data['file_download'] = getFileByType($data['manuscript']->manuscriptFiles, $file_type);

        return $data;
    }

    public function getAuthorViewData($manuscript_id)
    {
        $data = $this->getViewDataById($manuscript_id);

        // Get data for keyword combobox 
        $data['keyword_en'] = $this->getListKeywords('lang_code', EN , 'id', 'text');
        $data['keyword_vi'] = $this->getListKeywords('lang_code', VI, 'id', 'text');
        
        $data['keyword_en_selected'] = $this->getDataComboboxSelected($manuscript_id, EN);
        $data['keyword_vi_selected'] = $this->getDataComboboxSelected($manuscript_id, VI);

        //Chi cho phep tac gia chinh sua khi ban thao bi yeu cau chinh sua hoac khi UNSUBMIT
        $data['disabled'] = in_array($data['manuscript']->status, array(IN_SCREENING_EDIT, IN_REVIEW_EDIT, UNSUBMIT)) ? false : true;
        $data['disable_edit'] = (is_null($data['manuscript']->is_pre_public) && !is_null($data['manuscript']->is_print_out)) ? false : true;

        return $data;
    }

    //save comment for section editor
    public function saveSectionEditor($data, $id, $editor_manuscript_id = null)
    {
        // Upload file with file type = SE_FILE
        if (isset($data['file'])) {
            $this->uploadFileEditor($id, $this->user->id, SE_FILE);
        }

        $manuscript = $this->model->find($id);

        //section editor assign manuscript for copy editor in editing stage
        if (isset($data['editor_id'])) {
            $manuscript->fill($data);
            $manuscript->save();

            return null;
        }

        $manuscript->is_review = $data['is_review'];
        $data['stage'] = getStageByStatus($manuscript->status);
        $data['current_id'] = $manuscript->current_editor_manuscript_id;
        $manuscript->current_editor_manuscript_id = $data['current_id'];
        $manuscript->save();

        return $this->saveEditorManuscript($data, $id, $editor_manuscript_id);
    }

    public function saveEditorManuscript($data, $id, $editor_manuscript_id)
    {
        if ($editor_manuscript_id) {
            $editor_manuscript = EditorManuscript::find($editor_manuscript_id);
        } else {
            $editor_manuscript = new EditorManuscript();
        }
        isset($data['decide']) ? $data['decide'] = $data['decide'] : '';
        if(!isset($data['decide']))
            $data['decide'] = '';
        $data['manuscript_id'] = $id;
        $data['user_id'] = $this->user->id;
        $editor_manuscript->fill($data);
        $editor_manuscript->save();

        return $editor_manuscript;
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

        //check if current user is in rejected reviewer list
        if (findInSet($this->user->id, $data['manuscript']->reject_reviewer_ids)) 
        {
            $data['rejected_user'] = true;
        } else {
            $data['rejected_user'] = false;
        }

        $data['stage'] = getStageByStatus($data['manuscript']->status);
        $data['current_id'] = makeCurrentId($manuscript_id, $data['stage'], $data['loop']);  

        return $data;
    }

    //save comment for chief editor
    public function saveChiefEditor($data, $id, $editor_manuscript_id = null)
    {
        $manuscript = $this->model->find($id);
        $manuscript->status = $this->nextStatus($manuscript->status, $data['decide'], $id);
        if (isset($data['pre_journal_id'])) {
            $manuscript->pre_journal_id = $data['pre_journal_id'];
            $manuscript->order = $this->countManuscripts($data['pre_journal_id']) + 1;
        }

        $data['stage'] = getStageByStatus($manuscript->status);
        if (!in_array($manuscript->status, [IN_SCREENING_REFUSE, IN_REVIEW_REFUSE, IN_SCREENING_EDIT, IN_REVIEW_EDIT])) {
            $data['current_id'] = makeCurrentId($id, $data['stage'], 1);
        } else {
            $data['current_id'] = $manuscript->current_editor_manuscript_id;
        }

        $manuscript->current_editor_manuscript_id = $data['current_id'];

        $manuscript->save();

        return $this->saveEditorManuscript($data, $id, $editor_manuscript_id);
    }

    public function saveCopyEditor($data, $id, $editor_manuscript_id)
    {
        $manuscript = $this->model->find($id);
        //Giai đoạn hiệu đính: btv bản thảo upload file hiệu đính
        if (isset($data['file'])) {
            $this->uploadFileEditor($id, $this->user->id, REVISE_FILE);
        }
        //Giai đoạn hiệu đính: data gồm id btv chế bản,
        //update trạng thái bản thảo sang đã hiệu đính
        $manuscript->fill($data);
        $manuscript->save();

        return $this->saveEditorManuscript($data, $id, $editor_manuscript_id);
    }

    public function formModifyEditor($data, $id, $editor_manuscript_id = null)
    {
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

            return null;
        }

        //save comment and decide
        if ($editor_manuscript_id) {
            $editor_manu_id = EditorManuscript::where('manuscript_id', $id)
                                                    ->where('user_id', $editor_manuscript_id)
                                                    ->first()->id;
            $editor_manuscript = $this->editor_model->find($editor_manu_id);
        } else {
            $editor_manuscript = $this->editor_model;
        }

        if($data['decide']) 
        {
            is_array($data['decide']) ? $data['decide'] = current($data['decide']) : ''; 
        }

        $data['manuscript_id'] = $id;
        $data['user_id'] = $this->user->id;
        $editor_manuscript->fill($data);  

        // $data = $this->saveEditorManuscript($data, $id, $editor_manuscript_id);

        if ($this->hasPermission(SCREENING_EDITOR) and isset($data['is_sent']) and $data['is_sent'] != 1 ) {
            $this->saveDraftScreeningEditor($id, $editor_manuscript, $manuscript);
            
            return null;
        } 

        $editor_manuscript->save();

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

        $stage = getStageByStatus($manuscript->status);
        if (!in_array($manuscript->status, [IN_SCREENING_REFUSE, IN_REVIEW_REFUSE, IN_SCREENING_EDIT, IN_REVIEW_EDIT])) 
        {
            $manuscript->current_editor_manuscript_id = makeCurrentId($id, $stage, 1);
        }

        $manuscript->save();

        if($data['is_sent'] == 1 and $data['decide'] == ACCEPT) 
        {
            // Go to next stage
            // Create Editor Manuscript
            $editor_manu = new  EditorManuscript;

            // Setup EditorManuscript
            $editor_manuscript->stage = $stage++;
            $current_id = makeCurrentId($id, $editor_manuscript->stage, 1);

            $editor_manu->current_id = $current_id;
            $editor_manu->loop = 1;
            $editor_manu->is_sent = 0;
            $editor_manu->manuscript_id = $manuscript->id;

            $editor_manu->save();

            //save manuscript with new current_id
            $manuscript->current_editor_manuscript_id = $current_id;
            $manuscript->save();
        }
    }

    public function saveDraftScreeningEditor($id, $editor_manuscript, $manuscript)
    {
        if(empty($editor_manuscript->current_editor_manuscript_id))
        {
            $editor_manuscript->loop = 1;
            $editor_manuscript->stage = SCREENING;
            $current_id = makeCurrentId($id, SCREENING, 1);
        }
        else
        {
            $current_id = makeCurrentId($id, SCREENING, $editor_manuscript->loop);
        }

        
        $editor_manuscript->current_id = $current_id;
        $editor_manuscript->save();
        $manuscript->status = IN_SCREENING;
        $manuscript->current_editor_manuscript_id = $current_id;

        $manuscript->save();
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
        // hiệu đính, kết thúc công việc của copy editor trong phần hiệu đính
        // cho theo dõi đến khi xuất bản
        $manuscript->is_revise = $data['is_revise'];

        // select layout editor id
        $manuscript->layout_editor_id = $data['layout_editor_id'];

        $manuscript->save();

        // Upload file with file type = REVISE_FILE
        if (isset($data['file']) and !empty($data['file'])) {
            // lựa chọn file do copy editor upload lên
            $this->uploadFileEditor($manuscript->id, $user_id, REVISE_FILE);
        } 
        // else
        // {
        //     // nếu ko có file do copy editor upload lên, lựa chọn phiên bản của tác giả
        //     // $this->createNewManuscriptFile($id, $this->user->id, REVISE_FILE, NEW_MANUSCRIPT_FILE);
        //     $this->uploadFileEditor($id, $user_id, REVISE_FILE);
        // }

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
            $this->uploadFileEditor($id, $user_id, LAYOUT_PRINT_FILE);
        }
    }

    public function layoutEditorStartPublish($manuscript, $id)
    {
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


    public function saveLayoutEditor($data, $id, $editor_manuscript_id)
    {
        $manuscript = $this->model->find($id);
        //Giai đoạn chế bản: btv chế bản upload file chế bản
        $file_type = LAYOUT_PRINT_FILE;

        //Giai đoạn kiểm bông: btv chế bản upload file sơ bản,
        //kết thúc quá trình biên tập, update status bản thảo sang xuất bản
        if (isset($data['is_pre_public'])) {
            $file_type = PRE_PRINT_FILE;
            $data['status'] = PUBLISHED;
            $data['current_editor_manuscript_id'] = makeCurrentId($id, PUBLISHING, 1);
        }

        if (isset($data['file'])) {
            $this->uploadFileEditor($id, $this->user->id, $file_type);
        }

        $manuscript->fill($data);
        $manuscript->save();

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
                case RE_REVIEW:
                    return IN_REVIEW_EDIT;
            }
        }

        if ($current_status == IN_EDITING) {
            switch ($decide) {
                case ACCEPT:
                    
                    return PUBLISHED;
                
                default:
                    # code...
                    break;
            }
        }
    }

    public function getByIdWith($id)
    {
        $relations ['manuscriptFiles'] = function($query) {
            $query->orderBy('updated_at', 'asc');
        };

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

    //Get list manuscript data for each user type

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

	public function getByStatus($status = null){

		switch ($status) {
			case IN_REVIEW:				
				$data = $this->getDataInReview($this->user, $status);
				break;
			case UNSUBMIT:

				$data = $this->getUnsubmit();
                break;
            // case REJECTED:
            case IN_SCREENING_REFUSE:
            case IN_REVIEW_REFUSE:
                $data = $this->getDataRejected($this->user, $status);
                break;
            case IN_SCREENING:
                $data = $this->getDataInScreening($this->user, $status);
                break;
            case REJECTED_REVIEW:
                $data = $this->getDataRejectedReview($this->user, $status);
                break;
			case REVIEWED:				
				$data = $this->getDataReviewer($this->user, $status);
                // $data = $this->getReviewed();
				break;
            case IN_EDITING:
                $data = $this->getInEditing();
                break;
			case PUBLISHED:
				$data = $this->getDataPublished($this->user, $status);
                break;

            case WITHDRAWN:
                $data = $this->getDataWithDrawn($this->user, $status);
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

    public function uploadFile(){
        if(doUploadDocument()){

            return $_FILES["file"]["name"] . '/' . basename($_FILES["file"]["name"]);
        }

        return '';
    }
    
    public function uploadFileEditor($manu_id, $user_id, $file_type, $total_page = 0){
        $new_manu = $this->createNewManuscriptFile($manu_id, $user_id, $file_type, $total_page);
        $new_manu->save();
        
        if(!$_FILES)

            return false;

        if(doUploadDocument()){
            // Update Manuscript files with file type
            $this->saveManuscriptFiles($manu_id, $user_id, $file_type);

            //return path file if ok
            return $_FILES["file"]["name"] . '/' . basename($_FILES["file"]["name"]);
        }

        return '';
    }

    public function downloadFile($manu_file_id)
    {
        // Get full path in ManuscriptFiles table
        $manuFiles = ManuscriptFile::find($manu_file_id);
        
        $file_path = $manuFiles ? $manuFiles->name : '';
        
        // Download File
        doDownloadFileWithFullPath(public_path() . FILE_PATH . '/' . $file_path);

        return true;
    }

    public function createNewManuscriptFile($manu_id, $user_id, $file_type, $total_page = 0)
    {
    	$manu_file = new ManuscriptFile;

    	$manu_file->manuscript_id = $manu_id;
    	$manu_file->user_id = $user_id;
        $manu_file->type = $file_type;
        $manu_file->total_page = $total_page;
        
        // $manu_file->save();
        
        return $manu_file;
    }

    public function restoreStatusListbox($manuscripts)
    {

        $manuscripts->keyword_vi = explode(',', $manuscripts->keyword_vi);
        $manuscripts->keyword_en = explode(',', $manuscripts->keyword_en);

        return $manuscripts;
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
								->lists('keyword_id');
                                
		return $temp;
	}

    public function checkIsAuthor()
    {
        if(!$this->hasPermission(AUTHOR))
        {
            abort(333);
        }
    }

    public function getDataKeyword()
    {
        $keyword_en = $this->getDataCombobox('lang_code', EN , 'id', 'text');
        $keyword_vi = $this->getDataCombobox('lang_code', VI, 'id', 'text');

        // $temp = Keyword::all();
        // dd($temp);

        return array('keyword_en'   =>  $keyword_en, 'keyword_vi'    =>  $keyword_vi);
    }

    public function getDataFormEditManuscript($id, $manuscripts)
    {
        $keyword_en_selected = null;
        $keyword_vi_selected = null;
        $disabled = false;      // edit or disable control
        $is_new = true;         // new or edit manuscript 
        $need_edit = false;     // need edit again ?
        $is_withdrawn = false;  // withdrawn ?

        // if user hasn't permission
        ($this->user->id != $manuscripts->author_id) ? abort(333) : '' ;

        // Get data for keyword combobox 
        $manuscripts = $this->restoreStatusListbox($manuscripts);
        $keyword_en_selected = $this->getDataComboboxSelected($id, EN);
        $keyword_vi_selected = $this->getDataComboboxSelected($id, VI);

        if($manuscripts) 
        {
            $is_new = false;
            ($manuscripts->status == WITHDRAWN) ? $is_withdrawn = true : '';
            ($manuscripts->status == IN_SCREENING_EDIT || $manuscripts->status == IN_REVIEW_EDIT) ? $need_edit = true : '';
        } 
        else
        {
            $manuscripts = $this;
        }
        
        $disabled = $this->checkDisabledEditManuscript($manuscripts);

        return array('keyword_en_selected'  =>  $keyword_en_selected, 
                    'keyword_vi_selected'   =>  $keyword_vi_selected, 
                    'need_edit'             =>  $need_edit,
                    'is_withdrawn'          =>  $is_withdrawn,
                    'is_new'                =>  $is_new,
                    'disabled'              =>  $disabled,
                    'manuscripts'           =>  $manuscripts,
                    );
    }

    public function getDataFormNewManuscript($manuscripts)
    {

        return array('keyword_en_selected'  =>  null, 
                    'keyword_vi_selected'   =>  null, 
                    'need_edit'             =>  false,
                    'is_withdrawn'          =>  false,
                    'is_new'                =>  true,
                    'disabled'              =>  false,
                    'manuscripts'           =>  $manuscripts,
                    );
    }

    public function getDataRefuse()
    {
        $permission = $this->getPermission();
        $result_screening = $this->getColumnTable(IN_SCREENING_REFUSE, $permission);
        $result_reviewing = $this->getColumnTable(IN_REVIEW_REFUSE, $permission);
        $result_screening['data'] = $result_reviewing['data']->merge($result_screening['data']);

        return $result_screening;
    }

    public function getListKeywords($field, $value, $key_field_name, $value_field_name)
    {
        $temp = Keyword::where($field, $value)->get();

        $id_arr = $temp->lists($key_field_name);
        $values_arr = $temp->lists($value_field_name);

        return array_combine($id_arr, $values_arr);
    }
}
