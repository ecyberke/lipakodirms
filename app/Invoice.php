<?php

namespace App;

use App\Events\InvoiceUpdated;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use SoftDeletes;

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'updated' => InvoiceUpdated::class,
    ];

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

    public function payowners()
    {
        return $this->hasMany(Payowners::class);
    }
    /**
     * Scope a query to only include unpaid invoices.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUnpaid($query)
    {
        return $query->where('is_paid', 0);
    }

    public function scopePaid($query)
    {
        return $query->where('is_paid', 1);
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
