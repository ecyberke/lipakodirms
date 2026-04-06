<?php
namespace App\Http\Middleware;

use Closure;
use App\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\View;

class SubdomainMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $host = $request->getHost();
        
        // Extract subdomain
        // Works for: demo.lipakodi.ecyber.co.ke or demo.lipakodi.co.ke
        $parts = explode('.', $host);
        $subdomain = count($parts) >= 2 ? $parts[0] : null;
        
        // Super admin panel
        if ($subdomain === 'app') {
            Config::set('app.org_id', 0);
            Config::set('app.subdomain', 'app');
            Config::set('app.is_super_admin', true);
            View::share('current_org', null);
            View::share('is_super_admin', true);
            return $next($request);
        }

        // Find organization by subdomain slug
        if ($subdomain && $subdomain !== 'www' && $subdomain !== 'lipakodi') {
            $org = Organization::where('slug', $subdomain)
                ->where('status', '!=', 'cancelled')
                ->first();

            if (!$org) {
                abort(404, 'Organization not found');
            }

            // Check subscription status
            $subscription = $org->subscription;
            
            if ($org->status === 'suspended') {
                if (!$subscription || $subscription->grace_ends_at < now()) {
                    // Hard suspension - redirect to suspended page
                    if (!$request->is('suspended') && !$request->is('login')) {
                        return redirect('/suspended');
                    }
                }
            }

            Config::set('app.org_id', $org->id);
            Config::set('app.subdomain', $subdomain);
            Config::set('app.is_super_admin', false);
            Config::set('app.organization', $org);
            Config::set('app.currency', $org->currency);
            // Override SMS config with org-specific credentials if set
            if ($org->sms_api_token) {
                Config::set('app.sms_api_token', $org->sms_api_token);
                Config::set('app.sms_sender_id', $org->sms_sender_id ?? config('app.sms_sender_id'));
                Config::set('app.sms_admin_phone', $org->sms_admin_phone ?? config('app.sms_admin_phone'));
            }
            // Override M-Pesa config with org-specific credentials if set
            if ($org->mpesa_consumer_key) {
                Config::set('services.mpesa.consumer_key', $org->mpesa_consumer_key);
                Config::set('services.mpesa.consumer_secret', $org->mpesa_consumer_secret);
                Config::set('services.mpesa.shortcode', $org->mpesa_shortcode);
                Config::set('services.mpesa.passkey', $org->mpesa_passkey);
                Config::set('services.mpesa.paybill', $org->mpesa_paybill);
            }
            View::share('current_org', $org);
            View::share('is_super_admin', false);

            // Share subscription info with all views
            if ($subscription) {
                $daysLeft = $subscription->daysUntilExpiry();
                View::share('subscription', $subscription);
                View::share('subscription_days_left', $daysLeft);
                View::share('show_renewal_notice', $daysLeft <= 14);
            }
        } else {
            // Root domain - treat as demo or redirect to app
            $org = Organization::where('slug', 'demo')->first();
            if ($org) {
                Config::set('app.org_id', $org->id);
                Config::set('app.organization', $org);
                Config::set('app.currency', $org->currency);
                View::share('current_org', $org);
            }
            Config::set('app.is_super_admin', false);
        }

        return $next($request);
    }
}
