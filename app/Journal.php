<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Journal extends Model
{
	public $timestamps  = true;
    use SoftDeletes;
    // protected $dates = ['deleted_at'];
    protected $table    = 'journals';
    protected $fillable = ['name',
    						'num',
    						'cover',
    						'publish_at',
    						'expect_publish_at',
    						];
    protected $guarded  = ['id'];

    public function manuscripts()
    {
        return $this->hasMany('App\Manuscript', 'pre_journal_id');
    }
}
