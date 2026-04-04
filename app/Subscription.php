<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $guarded = [];
    protected $dates = ['starts_at', 'ends_at', 'grace_ends_at', 'paid_at'];

    public function organization() {
        return $this->belongsTo(Organization::class);
    }

    public function plan() {
        return $this->belongsTo(SubscriptionPlan::class, 'subscription_plan_id');
    }

    public function isExpired() {
        return $this->ends_at < now();
    }

    public function daysUntilExpiry() {
        return now()->diffInDays($this->ends_at, false);
    }

    public function getGraceDays() {
        return match($this->billing_cycle) {
            'monthly' => 7,
            'quarterly' => 15,
            'half_yearly' => 30,
            'annual' => 30,
            default => 7
        };
    }
}
