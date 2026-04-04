<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Organization extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public function subscription() {
        return $this->hasOne(Subscription::class)->latest();
    }

    public function subscriptions() {
        return $this->hasMany(Subscription::class);
    }

    public function users() {
        return $this->hasMany(User::class, 'org_id');
    }

    public function isActive() {
        return $this->status === 'active';
    }

    public function isInGrace() {
        return $this->status === 'suspended' && 
               $this->subscription && 
               $this->subscription->grace_ends_at >= now();
    }

    public function getMonthlyAmount() {
        $plan = SubscriptionPlan::where('units_min', '<=', $this->total_units)
            ->where(function($q) {
                $q->where('units_max', '>=', $this->total_units)
                  ->orWhereNull('units_max');
            })->first();
        return $plan ? $plan->price_per_unit * $this->total_units : 0;
    }
}
