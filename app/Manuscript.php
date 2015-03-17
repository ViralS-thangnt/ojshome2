<?php namespace App;

use Illuminate\Database\Eloquent\Model;

use Constant;
class Manuscript extends Model
{
    public $timestamps  = true;
    protected $table    = 'manuscripts';
    protected $fillable = ['author_id', 
                            'author_comments', 
                            'type', 
                            'expect_journal_id', 
                            'publish_journal_id',
                            'name', 
                            'summary_vi', 
                            'keyword_vi', 
                            'summary_en', 
                            'keyword_en', 
                            'topic', 
                            'recommend', 
                            'propose_reviewer',
                            'co_author', 
                            'file', 
                            'is_chief_review', 
                            'chief_decide', 
                            'is_revise', 
                            'is_print_out',
                            'is_pre_public', 
                            'status', 
                            'num_page',  
                            'file_final',
                            'section_loop',
                            'review_loop',
                            'screen_loop', 
                            'send_at'];
    protected $guarded  = ['id'];

    //Define Manuscript Relationship
    public function user()
    {
        return $this->belongsTo('App\User', 'author_id');
    }

    public function editorManuscripts()
    {
        return $this->hasMany('App\EditorManuscript');
    }

    ////define scope
    // public function scopeStatus($query, $status, $author_id)
    // {

    //     return $query->where('status', '=', $status)
    //                  ->where('author_id', '=', $author_id);
    // }
    

// test ================================================================================================

    public function scopeSelectColumns($query, $col)
    {
        $result = $query->select($col);

        return $result;
    }
    public function scopeJoinJournals($query, $col)
    {
        $result = $query->select($col);

		return $result;
	}
	// public function scopeJoinJournals($query)
	// {
	// 	return $query->leftJoin('journals', 'manuscripts.publish_pre_no', '=', 'journals.id');
	// }
	public function scopeJoinEditorManuscripts($query)
	{
		return $query->join('editor_manuscripts', function($join)
        {
            $join->on('manuscripts.id', '=', 'editor_manuscripts.manuscript_id')
                 ->on('manuscripts.status', '=', 'editor_manuscripts.stage');
        });
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
			});
			
			return array('data' => $manuscripts, 'col_header' => $col_header, 'col_db' => $col_db);

		} else if(in_array(SECTION_EDITOR, $permissions)) {

			$manuscripts = Manuscript::where('status', '=', IN_REVIEW)
							->joinUsers()
							->joinSectionManuscripts()
							->joinReviewmanuscripts()
							->select(
									'manuscripts.id', 'manuscripts.send_at', 'manuscripts.name',
									'manuscripts.chief_decide as round_decide_chief_editor',
									'users.last_name', 
									'section_manuscripts.section_loop as round_no_review',
									'section_manuscripts.name as section_editor',
									'manuscripts.is_chief_review as notify_chief_editor')
							->get();

			array_push($col_db, 'reviewer', 'notify_chief_editor', 'round_decide_chief_editor');
			array_push($col_header, 'Phản biện', 'Thông báo tổng biên tập', 'Quyết định của tổng biên tập');	

		} else if(in_array(MANAGING_EDITOR, $permissions)) {
			
			$manuscripts = Manuscript::where('status', '=', IN_REVIEW)
							->joinUsers()
							->joinSectionManuscripts()
							->joinReviewmanuscripts()
							->select(
									'manuscripts.id', 'manuscripts.send_at', 'manuscripts.name',
									'manuscripts.chief_decide as round_decide_chief_editor',
									'users.last_name', 
									'section_manuscripts.section_loop as round_no_review',
									'section_manuscripts.name as section_editor',
									'review_manuscripts.name as reviewer')
							->get();

			array_push($col_db, 'reviewer', 'section_editor', 'round_decide_chief_editor');
			array_push($col_header, 'Phản biện', 'Biên tập viên chuyên trách', 'Quyết định của tổng biên tập');

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

			return array('data' => $manuscripts, 'col_header' => $col_header, 'col_db' => $col_db);
			
		} 

		return array('data' => $manuscripts, 'col_header' => $col_header, 'col_db' => $col_db);
	}
	
	public function scopeStatus($query, $status, $author_id)
	{

		return $query->select('manuscripts.*', 'users.last_name', 'users.first_name', 'users.middle_name')
					 ->leftJoin('users', 'users.id', '=', 'manuscripts.author_id')
					 ->where('manuscripts.status', '=', $status)
					 ->where('manuscripts.author_id', '=', $author_id)
					 ->get();
	}

	public function scopeJoinSectionManuscripts($query)
	{

		return $query->leftJoin('section_manuscripts', function($join)
		{
			$join->on('users.id', '=', 'section_manuscripts.user_id')
				->on('manuscripts.id', '=', 'section_manuscripts.manuscript_id');
		});
	}

    public function scopeJoinReviewManuscripts($query)
    {
        
        return $query->leftJoin('review_manuscripts', function($join){
                            $join->on('users.id', '=', 'review_manuscripts.user_id')
                                ->on('manuscripts.id', '=', 'review_manuscripts.manuscript_id');
                        });
    }

    public function scopeJoinUsers($query) 
    {

        return $query->leftJoin('users', 'users.id', '=', 'manuscripts.author_id');
    }

    public function scopeAuthorId($query, $user_id)
    {

        return $query->where('manuscripts.author_id', '=', $user_id);
    }
}