<?php

namespace App\Http\Middleware;
use App\Models\User;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckOrganizationAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        /** @var User $user */
        $user = Auth::user();
        $organizationId = $request->route('organization')?->id ?? $request->input('organization_id');

        // Admin sistem bisa akses semua
        if ($user->canManageAllOrganizations()) {
            return $next($request);
        }

        // Admin organisasi hanya bisa akses organisasinya
        if ($user->isOrganizationAdmin() && $user->organization_id == $organizationId) {
            return $next($request);
        }

        // Member hanya bisa view organisasinya
        if ($user->isMember() && $user->organization_id == $organizationId && $request->isMethod('GET')) {
            return $next($request);
        }

        abort(403, 'Anda tidak memiliki akses ke organisasi ini.');
    }
}

