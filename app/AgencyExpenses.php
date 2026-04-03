<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AgencyExpenses extends Model
{
    use SoftDeletes;

    protected $guarded = [];
    protected $table = 'agency_expenses';
}
