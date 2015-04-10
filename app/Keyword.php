<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Keyword extends Model
{
	public $timestamps  = true;
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $table    = 'keywords';
    protected $fillable = ['lang_code', 'text'];
    protected $guarded  = ['id'];

    public function keywordManuscripts()
    {
        return $this->hasMany('App\KeywordManuscript', 'keyword_id', 'id');
    }

}