<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Overpaid extends Model
{

// MAss assignable attributes
    protected $fillable = [
        'tenant_id', 'amount', 'house_id',
    ];

    public function tenant()
    {
        return $this->belongsTo('App\Tenant');
    }

    public function house()
    {
        return $this->belongsTo('App\House');
    }

    

    /**
     * Scope a query to only fetch overpayments above 0.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeHasOverpayment($query)
    {
        return $query->where('amount', '>', 0);
    }
}
