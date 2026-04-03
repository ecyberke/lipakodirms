<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class Bills extends Model
{



    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // protected $fillable = [
    //     'house_id', 'rent', 'bills',
    //     'penalty_fee', 'rent_month', 'is_paid', 'overpayment','total_payable','carryforward','balance'
    // ];
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
        return $this->belongsToMany('App\Apartment');
    }
    /**
     * Scope a query to only include unpaid invoices.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUnpaid($query)
    {
        return $query->where('status', 0);
    }

    public function scopePaid($query)
    {
        return $query->where('status', 1);
    }
    public function scopePartial($query)
    {
        return $query->where('status', 2);
    }

    // /**
    //  * Get the invoice's total payable amount.
    //  *
    //  * @param  string  $value
    //  * @return string
    //  */
    // public function getTotalPayableAttribute()
    // {
    //     return ($this->rent + $this->bills + $this->penalty_fee + $this->carryforward)
    //          -
    //         ($this->overpayment);
    // }
    // /**
    //  * Get the invoice's unpaid balance.
    //  *
    //  * @param  string  $value
    //  * @return string
    //  */
    // public function getBalanceAttribute()
    // {
    //     return $this->total_payable - $this->paid_in;
    // }
}
