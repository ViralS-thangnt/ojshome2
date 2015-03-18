<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

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

    /* Define which author this manuscript belong to */
    public function author()
    {
        return $this->belongsTo('App\User', 'author_id');
    }


    /* Define which editor this manuscript belong to */

    public function editor()
    {
        return $this->belongsTo('App\User', 'editor_id');
    }


    /* Define which section editor this manuscript belong to */
    public function seEditor()
    {
        return $this->belongsTo('App\User', 'section_editor_id');
    }

    /* Log editor manuscript of this manuscript: one to many */

    public function editorManuscripts()
    {
        return $this->hasMany('App\EditorManuscript', 'manuscript_id');
    }

    public function editorManuscript()
    {
        return $this->hasOne('App\EditorManuscript','id','current_editor_manuscript_id');
    }

    ////define scope
    // public function scopeStatus($query, $status, $author_id)
    // {

    //     return $query->where('status', '=', $status)
    //                  ->where('author_id', '=', $author_id);
    // }

    //define scope
    public function scopeStatus($query, $status)
    {

        return $query->where('status', '=', $status);
    } 
    
    public function scopeJoinUsers($query) 
    {

        return $query->leftJoin('users', 'users.id', '=', 'manuscripts.author_id');
    }

    public function scopeAuthorId($query, $user_id)
    {

        return $query->where('manuscripts.author_id', '=', $user_id);
    }

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
		return $query->leftJoin('editor_manuscripts', function($join)
        {
            $join->on('manuscripts.id', '=', 'editor_manuscripts.manuscript_id')
                 ->on('manuscripts.status', '=', 'editor_manuscripts.stage');
        });
	}
}