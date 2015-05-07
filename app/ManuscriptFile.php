<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class ManuscriptFile extends Model
{
	public $timestamps  = true;
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $table    = 'manuscript_files';
    protected $fillable = ['manuscript_id', 'user_id', 'name', 'type', 'total_page', 'extension'];
    protected $guarded  = ['id'];
    protected $appends  = ['file_info'];

    public function getFileInfoAttribute()
    {
        return strtoupper($this->attributes['extension']).' | '.$this->attributes['total_page'].'p';
    }

    public function manuscript()
    {
  
        return $this->belongsTo('App\Manuscript', 'manuscript_id', 'id');
    }

    public function user()
    {
  
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function scopeOfTypes($query, $types = array())
    {
        return $query->whereIn('type', $types);
    }

}