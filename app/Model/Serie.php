<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Serie extends Model
{
    //
    public function video()
    {
        return $this->hasMany('App\Model\Video');
    }
}
