<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Zizaco\Entrust\Traits\EntrustUserTrait;
class User extends Model
{
    use EntrustUserTrait;

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
    // protected $fillable = ['name', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    // protected $hidden = ['password', 'remember_token'];

    /**
     * 用户和文章的关系
     */
    public function post()
    {
        return $this->hasMany('App\Model\Post');
    }

    /**
     * 用户和评论的关系
     */
    public function comment()
    {
        return $this->hasMany('App\Model\Comment');
    }
}