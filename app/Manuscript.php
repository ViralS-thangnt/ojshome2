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
    //========================QUAN DT============================/
    protected $appends = ['revise', 'print_out', 'pre_public'];

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
        return $this->hasMany('App\EditorManuscript', 'manuscript_id');
    }

    public function editorManuscript()
    {
        return $this->hasOne('App\EditorManuscript', 'id', 'current_editor_manuscript_id');
    }

    public function manuscriptFiles()
    {
        return $this->hasMany('App\ManuscriptFile', 'manuscript_id');
    }

    public function journalManuscriptPublish()
    {
        return $this->belongsTo('App\Journal', 'publish_journal_id');
    }
    
    // public function ManuscriptFiles()
    // {
    //     return $this->hasMany('App\ManuscriptFile', 'id');
    // }
    

    //define scope
    public function scopeStatus($query, $status)
    {

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

    //========================QUAN DT============================/
    public function scopeActor($query, $actor, $id)
    {
        switch ($actor) {
            case AUTHOR:
                return $query->where('manuscripts.author_id', $id);
            case MANAGING_EDITOR:
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
    //========================QUAN DT============================/

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