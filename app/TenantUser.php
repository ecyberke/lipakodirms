<?php
namespace App;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class TenantUser extends Authenticatable
{
    use Notifiable, SoftDeletes;
    protected $guard = 'tenant';
    protected $guarded = [];
    protected $hidden = ['password', 'remember_token'];

    public function tenant() {
        return $this->belongsTo(Tenant::class, 'tenant_id', 'account_number');
    }

    public function organization() {
        return $this->belongsTo(Organization::class, 'org_id');
    }
}
