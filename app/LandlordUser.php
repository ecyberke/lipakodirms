<?php
namespace App;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class LandlordUser extends Authenticatable
{
    use Notifiable, SoftDeletes;
    protected $guard = 'landlord';
    protected $guarded = [];
    protected $hidden = ['password', 'remember_token'];

    public function landlord() {
        return $this->belongsTo(Landlord::class, 'landlord_id', 'account_number');
    }

    public function organization() {
        return $this->belongsTo(Organization::class, 'org_id');
    }
}
