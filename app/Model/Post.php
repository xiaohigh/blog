<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    //
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * 文章和用户的关系  属于
     */
    public function user()
    {
    	return $this->belongsTo('App\User', 'author');
    }

    /**
     * 文章和分类的关系 属于
     */
    public function cate()
    {
        return $this->belongsTo('App\Model\Cate','cate_id');
    }

    /**
     * 文章和评论的关系 一对多
     */
    public function comment()
    {
        return $this->hasMany('App\Model\Comment');
    }

    /**
     * 文章跟标签的 多对多关系
     */
    public function tag()
    {
        return $this->belongsToMany('App\Model\Tag');
    }
}
