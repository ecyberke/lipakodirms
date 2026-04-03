<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Overpayment extends Model
{


   protected $fillable = [
        'tenant_id', 'amount'
    ];





  public function tenant()
  {
      return $this->belongsTo('App\Tenant');
  }
}
