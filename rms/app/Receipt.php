<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class Receipt extends Model
{
    // use SoftDeletes;

    protected $guarded = [];
    
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
    
    public function invoice()
    {
        return $this->belongsTo('App\Invoice');
    }
    public function manualpayment()
    {
        return $this->hasOne('App\ManualPayment');
    }
   
   

   
}
