<?php namespace App\Lib\Prototype\DBClasses\Eloquent;

use Illuminate\Contracts\Auth\Guard;
use App\Lib\Prototype\BaseClasses\AbstractEloquentRepository;
use App\Lib\Prototype\Interfaces\ManuscriptInterface;
use App\Manuscript;
use Input;
use Session;
use Constant;
use Redirect;
use DateTime;
// use ConstantArray;


class EloquentManuscriptRepository extends AbstractEloquentRepository implements ManuscriptInterface
{
    public function __construct(Manuscript $model)
    {
        $this->model = $model;
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

        if(Session::has('FILE_UPLOAD_SESSION'))

            $manuscript->file = Session::get('FILE_UPLOAD_SESSION');
        
        $manuscript->save();

        return $manuscript;
    }

    public function getById($id, array $with = array()){

        return $this->model->find($id);
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
			case M_REVIEWER:				
				$data = $this->getDataReviewer($this->user, $status);
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
                $data = $this->getDataWaitReview($this->user, $status);
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
            $manuscript->journal_name = $manuscript->journalManuscriptPublish->name;
            $manuscript->num          = $manuscript->journalManuscriptPublish->num;
            $manuscript->publish_at   = $manuscript->journalManuscriptPublish->publish_at;
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
                                    }]);

        if(in_array(ADMIN, $permissions) || in_array(CHIEF_EDITOR, $permissions)) 
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

            return array('data' => [], 'col_header' => [], 'col_db' => []);

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
            $manuscripts =  $manuscripts
                                    // ->selectColumns($col)
                                    ->whereHas('author', function($q) use($user){
                                        $q->where('id', $user->id);
                                    })
                                    ->get();
        } 
        else
        {
            $manuscripts =  $manuscripts
                                // ->selectColumns($col)
                                ->get();
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

            return array('data' => [], 'col_header' => [], 'col_db' => []);

        $col_header = Constant::$wait_review['col_header'];
        $col        = Constant::$wait_review['col'];
        $col_db     = Constant::$wait_review['col_db'];

        $manuscripts = Manuscript::where('status', '=', $status)->with('author')
                                    ->with(['editorManuscript' =>function($q){
                                        $q->select('id','loop','delivery_at','decide', 'deadline_at');
                                    }])
                                    ->whereHas('author', function($q) use($user){
                                        $q->where('id', $user->id);
                                    })
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
        else if(in_array(CHIEF_EDITOR, $permissions) || in_array(ADMIN, $permissions) || in_array(MANAGING_EDITOR, $permissions))
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

            return array('data' => $manuscripts, 'col_header' => $col_header, 'col_db' => $col_db);

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
        $obj_start = empty($start) ? date('m/d/Y', time()) : date_create_from_format("d/m/Y", Input::get('start'));
        $obj_end = empty($end) ? date('m/d/Y', time()) : date_create_from_format("d/m/Y", Input::get('end'));

        switch ($status) {
            case REJECTED:
                $count_manu = $this->getDataReportRejected($obj_start, $obj_end, $status);

                break;
            
            default:
                
                break;
        }
        $data = ['start' => $start, 'end' => $end, 'count_manu' => $count_manu];

        return $data;
    }

    public function getDataReportRejected($start, $end, $status)
    {
        $manuscripts = Manuscript::whereStatus($status)
                        ->where('updated_at', '>=', $start)
                        ->where('updated_at', '<=', $end)
                        ->get()
                        ;
                        // dump($manuscripts);

        return $manuscripts->count();
    }

    //========================QUAN DT============================/

    public function getUnsubmit()
    {
        $permissions = $this->getPermission();
        if (in_array(AUTHOR, $permissions)) {
            return $this->getColumnTable(UNSUBMIT, AUTHOR);
        }
    }

    public function getInEditing()
    {
        $permissions = $this->getPermission();
        $require_permissions = Constant::$require_permission[IN_EDITING];

        foreach ($require_permissions as $value) {
            if (in_array($value, $permissions)) {
                return $this->getColumnTable(IN_EDITING, $value);
            }
        }
    }

    public function getColumnTable($process, $actor)
    {
        return [
            'data'             =>  $this->getDataTable($process, $actor),
            'col_header'       =>  Constant::$tableColumns[$process][$actor]['col_header'],
            'col_db'           =>  Constant::$tableColumns[$process][$actor]['col_result'],
        ];
    }

    public function getDataTable($process, $actor)
    {
        $col = Constant::$tableColumns[$process][$actor]['col_select'];
        $relate_cols = Constant::$tableColumns[$process][$actor]['col_relate'];
        $relates = $this->getRelate($process, $actor);

        $data = $this->model->status($process)
                            ->actor($actor, $this->user->id)
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
            $result[$key] = function($query) use ($value) {
                $query->select($value);
            };
        }

        return $result;
    }

    //========================QUAN DT============================/

    public function uploadFile(){
        if(doUploadDocument()){
            
            return $_FILES["file"]["name"] . '/' . basename($_FILES["file"]["name"]);
        }

        return '';
    }

    public function restoreStatusListbox($manuscripts){

        $manuscripts->keyword_vi = explode(',', $manuscripts->keyword_vi);
        $manuscripts->keyword_en = explode(',', $manuscripts->keyword_en);

        return $manuscripts;
    }
}
