<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    public function houses()
    {
        return $this->belongsToMany('App\House')->withPivot('amount');
    }
}
