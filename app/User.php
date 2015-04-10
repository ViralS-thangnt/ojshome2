<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{

    use Authenticatable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['degree_id', 'academic_id', 'username', 'password', 'last_name', 'first_name',
                            'middle_name', 'sex', 'year', 'email', 'phone','address', 'nation',
                            'research_area', 'research', 'actor_no'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    protected $appends = ['full_name'];

    public function getFullNameAttribute()
    {
        
        return $this->attributes['last_name'].' '.$this->attributes['middle_name'].' '.$this->attributes['first_name'];
    }

    //Define User relationship
    public function manuscripts()
    {
        
        return $this->hasMany('App\Manuscript', 'author_id');
    }

    public function editorManuscripts()
    {
        
        return $this->hasMany('App\EditorManuscript', 'user_id', 'id');
    }

    public function manuscriptFiles()
    {
        
        return $this->hasMany('App\ManuscriptFile', 'user_id', 'id');
    }
    //Define User scope
    public function scopeActor($query, $actor)
    {
        
        return $query->whereRaw('FIND_IN_SET(?, actor_no)', [$actor]);
    }
}
