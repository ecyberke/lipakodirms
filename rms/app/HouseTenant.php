<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HouseTenant extends Model
{
    /**
 * The table associated with the model.
 *
 * @var string
 */

    protected $table='house_tenants';

    public function tenant()
    {
        return $this->belongsTo('App\Tenant');
    }

    public function house()
    {
        return $this->belongsTo('App\House');
    }

    public function invoices()
    {
        return $this->hasMany('App\Invoice');
    }
    public function apartment()
    {
        return $this->belongsTo('App\Apartment');
    }
    public function rent()
    {
        return $this->hasOne('App\Rent');
    }
}
