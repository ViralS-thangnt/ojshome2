<?php namespace App\Lib\Prototype\DBClasses\Eloquent;

use Illuminate\Contracts\Auth\Guard;
use App\Lib\Prototype\BaseClasses\AbstractEloquentRepository;
use App\Lib\Prototype\Interfaces\ManuscriptInterface;
use App\Manuscript;
use Input;
use Session;
use Constant;


class EloquentManuscriptRepository extends AbstractEloquentRepository implements ManuscriptInterface
{


    public function __construct(Manuscript $model, Guard $auth)
    {
        $this->model = $model;
        $this->auth = $auth;
        $this->user = $this->auth->user();
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
        // dd($manuscript);
        return $manuscript;
    }



    public function getById($id, array $with = array()){

        return $this->model->find($id);
    }

	public function getByStatus($status = null){
		switch ($status) {
			case IN_REVIEW:				
				$data = $this->getDataInReview($this->user);
				break;
			case UNSUBMIT:
				return $this->model->status('UNSUBMIT')->with('author')->get();
            case IN_SCREENING:
                $data = $this->getDataInScreening($this->user, $status);
                break;
			case M_REVIEWER:				
				$data = $this->getDataReviewed($this->user, $status);
				break;
			case PUBLISHED:
				$data = $this->getDataPublished($this->user, $status);
			default:
				$data = $this->getDataPublished($this->user, $status);
				break;
		}


		// dd($data);
		return $data;
	}

    //=======================================================================
// hàm dùng để lấy data cho trang http://..../admin/manuscript/reviewed
// các biến được sử dụng trong hàm
// $col        : các columns cần lấy ra 
// $col_header : tiêu đề của bảng hiển thị
// $key        : tên columns
// ======================================================================
    public static function getDataReviewed($user,$status)
    {
        $col_header = Constant::$reviewed['col_header'];
        $col        = Constant::$reviewed['col'];
        $col_db     = Constant::$reviewed['col_db'];

        $manuscripts = Manuscript::where('status', '=', $status)
                            ->selectColumns($col)
                            ->joinEditorManuscripts()
                            ->get();
                            
        $manuscripts->each(function ($manuscript) {
            $manuscript->deadline_at = date("d/m/Y", strtotime($manuscript->deadline_at));
            $manuscript->delivery_at = date("d/m/Y", strtotime($manuscript->delivery_at));
            $manuscript->process = $manuscript->status;
        });
        return array('data' => $manuscripts, 'col_header' => $col_header, 'col_db' => $col_db);

    }

// test ================================================================================================


    public static function getDataInReview($user) 
    {
        $permissions = explode(',', $user->actor_no);

        // $col_header = ['ID', 'Ngày gửi', 'Tên bài', 'Tác giả liên hệ', 'Tiến trình'];
        // $col_db = ['id', 'send_at', 'name', 'last_name', 'round_no_review']; 

        if(in_array(ADMIN, $permissions) || in_array(CHIEF_EDITOR, $permissions)) {
            $col_header = Constant::$in_review_chief_editor['col_header'];
            $col        = Constant::$in_review_chief_editor['col'];  
            $col_db     = Constant::$in_review_chief_editor['col_db'];

            $manuscripts = Manuscript::where('status', '=', IN_REVIEW)
                                ->selectColumns($col)
                                ->joinUsers()
                                ->joinEditorManuscripts()
                                ->get();
                                
            $manuscripts->each(function ($manuscript) {
                $manuscript->round_no_review = 'Bình luận vòng ' . $manuscript->round_no_review;
                $manuscript->send_at = date("d/m/Y", strtotime($manuscript->send_at));
                $manuscript->notify_chief_editor = Constant::$notify_chief_editor[$manuscript->notify_chief_editor];
                $manuscript->round_decide_chief_editor = Constant::$chief_decide[$manuscript->round_decide_chief_editor];
            });
            // dd($manuscripts);

        } else if(in_array(SECTION_EDITOR, $permissions)) {

            $col_header = Constant::$in_review_section_editor['col_header'];
            $col        = Constant::$in_review_section_editor['col'];  
            $col_db     = Constant::$in_review_section_editor['col_db'];

            $manuscripts = Manuscript::where('status', '=', IN_REVIEW)
                                ->selectColumns($col)
                                ->joinUsers()
                                ->joinEditorManuscripts()
                                ->get();
                                
            $manuscripts->each(function ($manuscript) {
                $manuscript->round_no_review = 'Bình luận vòng ' . $manuscript->round_no_review;
                $manuscript->send_at = date("d/m/Y", strtotime($manuscript->send_at));
                $manuscript->round_decide_chief_editor = Constant::$chief_decide[$manuscript->round_decide_chief_editor];
            });

            // dd($manuscripts);

        } else if(in_array(MANAGING_EDITOR, $permissions)) {
            $col_header = Constant::$in_review_section_editor['col_header'];
            $col        = Constant::$in_review_section_editor['col'];  
            $col_db     = Constant::$in_review_section_editor['col_db'];

            $manuscripts = Manuscript::where('status', '=', IN_REVIEW)
                                ->selectColumns($col)
                                ->joinUsers()
                                ->joinEditorManuscripts()
                                ->get();
                                
            $manuscripts->each(function ($manuscript) {
                $manuscript->round_no_review = 'Bình luận vòng ' . $manuscript->round_no_review;
                $manuscript->send_at = date("d/m/Y", strtotime($manuscript->send_at));
                $manuscript->round_decide_chief_editor = Constant::$chief_decide[$manuscript->round_decide_chief_editor];
                $manuscript->notify_chief_editor = Constant::$notify_chief_editor[$manuscript->notify_chief_editor];
            });

            // dd($manuscripts);

        } else if (in_array(AUTHOR, $permissions)) {
            $col_header = Constant::$in_review_author['col_header'];
           $col        = Constant::$in_review_author['col'];
           $col_db     = Constant::$in_review_author['col_db'];

           $manuscripts = Manuscript::where('status', '=', IN_REVIEW)
                                    ->selectColumns($col)
                                    ->joinUsers()
                                    ->authorId($user->id)
                                    ->joinEditorManuscripts()
                                    ->get();
                                   
           $manuscripts->each(function ($manuscript) {
                $manuscript->round_no_review = 'Bình luận vòng ' . $manuscript->round_no_review;
                $manuscript->send_at = date("d/m/Y", strtotime($manuscript->send_at));
           });
        } 

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
        $col        = Constant::$auther_public_view['col'];
        $col_db     = Constant::$auther_public_view['col_db'];

        $manuscripts = Manuscript::where('status', '=', $status)
                            ->selectColumns($col)
                            ->joinUsers()
                            ->joinJournals()
                            ->get();

        $manuscripts->each(function ($manuscript) {
            $manuscript->fullname = $manuscript->last_name .' '. $manuscript->first_name;
            $manuscript->send_at = date("d/m/Y", strtotime($manuscript->send_at));
            $manuscript->process = $manuscript->status;
        });

        return array('data' => $manuscripts, 'col_header' => $col_header, 'col_db' => $col_db);
    }

    public static function getDataInScreening($user, $status)
    {
        $permissions = explode(',', $user->actor_no);
        $col_header = Constant::$inScreeningAuthor['col_header'];
        $col        = Constant::$inScreeningAuthor['col'];
        $col_db     = Constant::$inScreeningAuthor['col_db'];
         
        if(in_array(CHIEF_EDITOR, $permissions)) {
            $col_header = Constant::$inScreeningChief['col_header'];
            $col        = Constant::$inScreeningChief['col'];
            $col_db     = Constant::$inScreeningChief['col_db'];
            
        }
        else if(in_array(SCREENING_EDITOR, $permissions)){
            $col_header = Constant::$inScreeningScreengEditor['col_header'];
            $col        = Constant::$inScreeningScreengEditor['col'];
            $col_db     = Constant::$inScreeningScreengEditor['col_db'];
        }
        
        $manuscripts = Manuscript::status($status)
                            ->selectColumns($col)
                            ->with(['author' =>function($q){
                                $q->select('id','last_name','middle_name','first_name');
                            }])
                            ->with(['editor' => function($q){
                                $q->select('id', 'first_name');
                            }])
                            ->with(['editorManuscript' =>function($q){
                                $q->select('id','loop','delivery_at','decide');
                            }])                         
                            ->get();
         
        $manuscripts->each(function ($manuscript) {
            
            $manuscript->fullname = $manuscript->author->last_name.' '. $manuscript->author->middle_name.' '. $manuscript->author->first_name;
            empty($manuscript->editor) ? null : $manuscript->editor_name = $manuscript->editor->first_name;
            $manuscript->send_at = date("d/m/Y", strtotime($manuscript->send_at));
            $manuscript->process = 'Sơ loại vòng '.$manuscript->editorManuscript->loop;
            empty($manuscript->editorManuscript) ? null : $manuscript->delivery_at = date("d/m/Y", strtotime($manuscript->editorManuscript->delivery_at));
            $manuscript->decide = $manuscript->editorManuscript->decide;
        });
     
        return array('data' => $manuscripts, 'col_header' => $col_header, 'col_db' => $col_db);
    }

    public function getByStatus2($status)
    {
        
    }


    public function uploadFile(){
        if(doUploadDocument()){
            
            return $_FILES["file"]["name"] . '/' . basename($_FILES["file"]["name"]);
        }

        return '';
    }
}
