<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Replies extends Model
{
    protected $guarded = [];
    
    public function message()
    {
        return $this->belongsTo('App\Message');
    }
    
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function manualpayment()
    {
        return $this->belongsTo('App\ManualPayment');
    }
}
