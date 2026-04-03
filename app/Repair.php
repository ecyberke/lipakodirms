<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Repair extends Model
{
    // use SoftDeletes;
    /**
     * The event map for the model.
     *
     * @var array
     */
    

    protected $guarded = [];
    public function landlord()
    {
        return $this->belongsTo('App\Landlord');
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
    public function tenant()
    {
        return $this->belongsTo('App\Tenant');
    }
   
}
