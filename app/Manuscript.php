<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletes;

use Constant;
class Manuscript extends Model
{
    public $timestamps  = true;
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $table    = 'manuscripts';
    protected $fillable = ['author_id', 

                            'editor_id',
                            'section_editor_id',
                            'layout_editor_id',
                            'invite_reviewer_ids',
                            'reject_reviewer_ids',
                            'reviewer_ids',
                            'deadline_at',
                            'delivery_at',
                            'current_editor_manuscript_id',
                            'author_comments', 
                            'type', 
                            'expect_journal_id', 
                            'publish_journal_id',
                            'pre_journal_id',
                            'name', 
                            'summary_vi', 
                            'summary_en', 
                            'topic', 
                            'recommend', 
                            'propose_reviewer',
                            'co_author', 
                            'is_chief_review', 
                            'chief_decide', 
                            'is_revise', 
                            'is_print_out',
                            'is_pre_public', 
                            'status', 
                            'num_page',  
                            'section_loop',
                            'review_loop',
                            'screen_loop', 
                            'send_at'];
    protected $guarded  = ['id'];

    public function keywordManuscripts()
    {
        return $this->hasMany('App\KeywordManuscript', 'manuscript_id', 'id');
    }

    //========================QUAN DT============================/
    protected $appends = ['revise', 'print_out', 'pre_public', 'process', 'chief_decide_text'];

    public function getReviseAttribute()
    {
        return getCheckIcon($this->attributes['is_revise']);
    }

    public function getPrintOutAttribute()
    {
        return getCheckIcon($this->attributes['is_print_out']);
    }

    public function getPrePublicAttribute()
    {
        return getCheckIcon($this->attributes['is_pre_public']);
    }

    public function getProcessAttribute()
    {

        return makeProcessNameById($this->attributes['current_editor_manuscript_id']);
    } 

    public function getChiefDecideTextAttribute()
    {

        return Constant::$chief_decide[$this->attributes['chief_decide']];
    }  
    //========================QUAN DT============================/

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
        return $this->hasMany('App\EditorManuscript', 'manuscript_id', 'id');
    }

    public function editorManuscript()
    {
        return $this->hasOne('App\EditorManuscript', 'current_id', 'current_editor_manuscript_id');
    }

    public function currentEditorManuscripts()
    {
        return $this->hasMany('App\EditorManuscript', 'current_id', 'current_editor_manuscript_id');   
    }

    public function reviewerManuscripts()
    {
        return $this->hasMany('App\EditorManuscript', 'current_id', 'current_editor_manuscript_id')->where();
    }

    public function manuscriptFiles()
    {
        return $this->hasMany('App\ManuscriptFile', 'manuscript_id', 'id');
    }

    public function journalManuscriptPublish()
    {
        return $this->belongsTo('App\Journal', 'publish_journal_id');
    }
    

    //define scope
    public function scopeStatus($query, $status)
    {
        if ($status == IN_SCREENING) {

            return $query->whereIn('status', [IN_SCREENING, IN_SCREENING_EDIT]);
        }

        if ($status == IN_REVIEW) {

            return $query->whereIn('status', [IN_REVIEW, IN_REVIEW_EDIT]);
        }

        return $query->where('status', '=', $status);
    } 


    public function deleteManuscript($result)
    {

        foreach ($result as $key => $value) {
            $model = $this->find($value);
            $model->delete();
        }
        return true;
    } 


    public function scopeJoinUsers($query) 
    {

        return $query->leftJoin('users', 'users.id', '=', 'manuscripts.author_id');
    }

    public function scopeAuthorId($query, $user_id)
    {

        return $query->where('manuscripts.author_id', '=', $user_id);
    }

    public function scopeActor($query, $actor, $id, $reviewer_list = false)
    {
        switch ($actor) {
            case AUTHOR:
                return $query->where('manuscripts.author_id', $id);
            case REVIEWER:
                if ($reviewer_list == WAIT_REVIEW) {
                    return $query->whereRaw('FIND_IN_SET(?, manuscripts.invite_reviewer_ids)', [$id]);    
                }

                if ($reviewer_list == REVIEWED) {
                    return $query->whereRaw('FIND_IN_SET(?, manuscripts.reviewer_ids)', [$id]);
                }

                if ($reviewer_list == REJECTED_REVIEW) {
                    return $query->whereRaw('FIND_IN_SET(?, manuscripts.reject_reviewer_ids)', [$id]);
                }              
            case MANAGING_EDITOR:
                return $query;
            case CHIEF_EDITOR:
                return $query;
            case SECTION_EDITOR:
                return $query->where('manuscripts.section_editor_id', $id);
            case LAYOUT_EDITOR:
                return $query->where('manuscripts.layout_editor_id', $id)
                             ->where('manuscripts.is_revise', 1);
            default:
                return $query->where('manuscripts.editor_id', $id);
        }
    }

    // author : Lanpt
    public function scopeCheckWhere($query, $pattern)
    {
        $result = null;
        foreach ($pattern as $key => $value) {
            $result = $query->where($key,$value);
        }        
        return $result;
    }


// test ================================================================================================

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

// ================================ TAO LE ================================================================

    public function scopeSelectColumns($query, $col)
    {
        $result = $query->select($col);
        return $result;
    }


// ================================ TAO LE ================================================================
}