<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Apartment extends Model
{
    use SoftDeletes;
    public function houses()
    {
        return $this->hasMany('App\House');
    }

    public function landlord()
    {
        return $this->belongsTo('App\Landlord');
    }
    public function client()
    {
        return $this->belongsTo('App\Landlord');
    }

    public function deposits()
    {
        return $this->hasMany('App\Deposit');
    }
    public function bills()
    {
        return $this->hasMany('App\Bills');
    }

    public function placementfees()
    {
        return $this->hasMany('App\PlacementFee');
    }
    public function service_requests()
    {
        return $this->hasMany('App\ServiceRequests');
    }
    public function payowners()
    {
        return $this->hasMany('App\Payowners');
    }

}
