<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{

    public function scopeActive($query)
    {
        return $query->where('is_active', '=', 1);
    }

    public function tenant()
    {
        return $this->belongsTo('App\Tenant');
    }
    public function house()
    {
        return $this->belongsTo('App\House');
    }

    public function apartment()
    {
        return $this->belongsTo('App\Apartment');
    }
}
