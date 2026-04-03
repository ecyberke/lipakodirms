<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class PayOwner extends Authenticatable
{
    use Notifiable;

    protected $guarded = [];
    protected $table = 'pay_owners';

    public function house()
    {
        return $this->belongsTo('App\House');
    }

}
