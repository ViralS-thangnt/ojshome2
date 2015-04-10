<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KeywordManuscript extends Model
{
	public $timestamps  = true;
    // use SoftDeletes;
    // protected $dates = ['deleted_at'];

    protected $table    = 'keyword_manuscripts';
    protected $fillable = ['manuscript_id', 'keyword_id'];
    protected $guarded  = ['id']; 

    public function manuscript()
    {
        return $this->belongsTo('App\Manuscript', 'manuscript_id', 'id');
    }

    public function keyword()
    {
        return $this->belongsTo('App\Keyword', 'keyword_id', 'id');
    }
}