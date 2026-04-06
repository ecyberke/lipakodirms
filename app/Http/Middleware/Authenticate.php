<?php
namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    protected function redirectTo(Request $request): ?string
    {
        if ($request->expectsJson()) {
            return null;
        }

        // Redirect to appropriate login based on route prefix
        if ($request->is('tenant-portal/*')) {
            return route('tenant.login');
        }

        if ($request->is('landlord-portal/*')) {
            return route('landlord.login');
        }

        if ($request->is('super-admin/*')) {
            return route('super.login');
        }

        return route('login');
    }
}
