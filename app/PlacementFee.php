<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlacementFee extends Model
{
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
