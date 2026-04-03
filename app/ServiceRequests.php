<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceRequests extends Model
{
    use SoftDeletes;

    protected $guarded = [];
    protected $table = 'service_requests';

    public function tenant()
    {
        return $this->belongsTo('App\Tenant');
    }

    public function apartment()
    {
        return $this->belongsTo('App\Apartment');
    }

    public function house()
    {
        return $this->belongsTo('App\House');
    }
}
