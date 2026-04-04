<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class OrgScopeMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Store org_id in app config for use in queries
        $orgId = config('app.org_id', 1);
        
        // Make org_id available globally
        app()->instance('org_id', $orgId);
        
        return $next($request);
    }
}
