<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HouseView extends Model
{
    use SoftDeletes;

    protected $guarded = [];
    protected $table = 'house_views';

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
}
