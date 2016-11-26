<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Cate extends Model
{
    //
    /**
     * 分类和文章的关系
     */
    public function post()
    {
    	return $this->hasMany('App\Model\Post');
    }
}
