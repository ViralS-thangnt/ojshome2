<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Constant;

class EditorManuscript extends Model
{


	protected $table    = 'editor_manuscripts';
	protected $fillable = ['stage', 'manuscript_id', 'user_id', 'loop', 'comments', 'decide',
						  'editor_suggested_id', 'file', 'delivery_at', 'deadline_at'];
    protected $appends = ['process'];

    public function getProcessAttribute()
    {
        if ($this->attributes['stage'] == EDITING) {
            return trans(Constant::$stage[$this->attributes['stage']]);
        } else {
            return trans(Constant::$stage[$this->attributes['stage']]).' '.trans('admin.round').' '.$this->attributes['loop'];
        }
    }

	public function manuscripts()
	{
		return $this->belongsTo('App\Manuscript', 'manuscript_id');
	}

    //define relationship
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function manuscript()
    {
        return $this->belongsTo('App\Manuscript', 'manuscript_id');
    }
}
