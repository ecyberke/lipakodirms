<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Landlord extends Authenticatable
{
    use SoftDeletes;
    use Notifiable;

    protected $guard = 'landlord';

    protected $keyType = 'string';

    protected $hidden = ['password'];

    public function apartments()
    {
        return $this->hasMany('App\Apartment');
    }

    public function houses()
    {
        return $this->hasManyThrough('App\Houses', 'App\Apartment');
    }

    public function deposits()
    {
        return $this->hasManyThrough('App\Deposit', 'App\Apartment');
    }
}
