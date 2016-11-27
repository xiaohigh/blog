<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    //
    public function serie()
    {
        return $this->belongsTo('App\Model\Serie');
    }
}
