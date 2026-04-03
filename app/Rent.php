<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rent extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'amount','electricity_bill', 'water_bill', 'litter_bill', 'compound_bill'
    ];




    public function House()
    {
        return $this->belongsTo('App\House');
    }
}
