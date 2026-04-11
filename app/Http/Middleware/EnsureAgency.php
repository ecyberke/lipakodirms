<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Organization;

class EnsureAgency
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if (!$user || !$user->org_id) {
            abort(403);
        }

        $org = Organization::find($user->org_id);

        if (!$org || !$org->isAgency()) {
            abort(403, 'This section is for agency accounts only.');
        }

        return $next($request);
    }
}
