<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class House extends Model
{
    use SoftDeletes;
    protected $guarded = [];
    public function apartment()
    {
        return $this->belongsTo('App\Apartment');
    }

    public function bills()
    {
        return $this->belongsToMany('App\Bill')->withPivot('amount');
    }

    public function rent()
    {
        return $this->hasOne('App\Rent');
    }

    public function deposits()
    {
        return $this->hasMany('App\Deposit');
    }
     public function invoices()
    {
        return $this->hasMany('App\Invoice');
    }

    public function tenant()
    {
        return $this->belongsTo('App\Tenant', 'tenant_id');
    }
    /**
     * Scope a query to only include active users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOccupied($query)
    {
        return $query->where('is_occupied', 1);
    }

    public function house_tenant()
    {
        return $this->hasOne('App\HouseTenant');
    }

    public function overpaid()
    {
        return $this->hasOne('App\Tenant');
    }

}
