<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceRequests extends Model
{   
    protected $guarded = [];
    public function tenant()
    {
        return $this->belongsTo('App\Tenant');
    }
    public function apartment()
    {
        return $this->belongsTo('App\Apartment');
    }
    public function house()
    {
        return $this->belongsTo('App\House');
    }

    
    
}
