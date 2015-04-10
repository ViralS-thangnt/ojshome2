<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Constant;

class EditorManuscript extends Model
{


	protected $table    = 'editor_manuscripts';
	protected $fillable = ['stage', 'current_id', 'manuscript_id', 'user_id', 'loop', 'comments', 'decide',
						  'editor_suggested_id', 'delivery_at', 'deadline_at', 'is_sent'];
    protected $appends = ['process', 'decide_text'];

    public function getProcessAttribute()
    {
        
        return makeProcessName($this->attributes['stage'], $this->attributes['loop']);
    }

    public function getDecideTextAttribute()
    {
        $decide = array_merge(Constant::$decide, Constant::$child_decide);

        return $decide[$this->attributes['decide']];
    }

	public function manuscripts()
	{
		return $this->belongsTo('App\Manuscript', 'manuscript_id');
	}

    //define relationship
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function manuscript()
    {
        return $this->belongsTo('App\Manuscript', 'manuscript_id');
    }

    public function scopeReviewTime($query)
    {
        $query->selectColumns(['(deadline_at - delivery_at) as review_time']);
    }
}
