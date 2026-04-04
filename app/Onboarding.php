<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Onboarding extends Model
{
     protected $guarded = [];
     
     
     public function getFormattedPhoneAttribute()
{
    $phone = $this->phone;
    if (Str::startsWith($phone, '0')) {
        return '+254' . substr($phone, 1);
    }
    return $phone;
}
}
