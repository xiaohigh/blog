<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    /**
     * 标签跟文章的多对多关系
     */
    public function post()
    {
    	return $this->belongsToMany('App\Model\Post');
    }

}
