<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class EditorManuscript extends Model {

	protected $table 	= 'editor_manuscripts';
	protected $fillable = ['stage', 'manuscript_id', 'user_id', 'loop', 'comments', 'decide',
                          'editor_suggested_id', 'file', 'delivery_at', 'deadline_at'];

	//define relationship

     public function user()
    {
        return $this->belongsTo('App\User');
    }

	public function manuscript()
	{
		return $this->belongsTo('App\Manuscript');
	}


}

