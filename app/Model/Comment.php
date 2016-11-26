<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /**
     * 评论和文章的关系  属于
     */
    public function post()
    {
    	return $this->belongsTo('App\Model\Post');
    }

    /**
     * 评论跟用户的关系
     */
    public function user()
    {
    	return $this->belongsTo('App\User');
    }
}
