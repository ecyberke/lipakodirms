<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Organization;

class SubscriptionCheck
{
    public function handle(Request $request, Closure $next)
    {
        $orgId = config('app.org_id', 0);
        
        // Skip check for super admin
        if ($orgId === 0 || config('app.is_super_admin')) {
            return $next($request);
        }

        $org = config('app.organization');
        if (!$org) {
            $org = Organization::find($orgId);
        }

        if ($org && $org->status === 'suspended') {
            $subscription = $org->subscription;
            if (!$subscription || $subscription->grace_ends_at < now()) {
                if ($request->expectsJson()) {
                    return response()->json(['error' => 'Subscription suspended'], 402);
                }
                return redirect('/suspended')->with('org', $org);
            }
        }

        return $next($request);
    }
}
