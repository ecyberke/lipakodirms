<?php

namespace App\Http\View\Composers;

use App\Organization;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class CurrentOrganizationComposer
{
    public function compose(View $view): void
    {
        $organization = null;

        if (Auth::check()) {
            $user = Auth::user();

            // org_id = 0 means super admin — no organization context
            if (!empty($user->org_id) && $user->org_id !== 0) {
                $organization = Organization::find($user->org_id);
            }
        }

        $view->with('currentOrganization', $organization);
    }
}
