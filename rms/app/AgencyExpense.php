<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class AgencyExpense extends Authenticatable
{
    use Notifiable;

    protected $guarded = [];
    protected $table = 'agency_expenses';

}
