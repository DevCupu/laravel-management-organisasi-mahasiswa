<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\Member;
use App\Models\Event;
use App\Models\Document;
use App\Models\Announcement;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        return match ($user->role) {
            'admin' => $this->adminDashboard($request),
            'organization_admin' => $this->organizationAdminDashboard($request),
            'member' => $this->memberDashboard($request),
            default => abort(403, 'Role tidak dikenali'),
        };
    }

    private function adminDashboard(Request $request)
    {
        $stats = [
            'total_organizations' => Organization::count(),
            'total_users' => User::count(),
            'total_members' => Member::where('status', 'active')->count(),
            'total_events' => Event::whereMonth('event_date', now()->month)->count(),
            'active_events' => Event::where('status', 'upcoming')->count(),
            'total_documents' => Document::count(),
            'organization_admins' => User::where('role', 'organization_admin')->count(),
        ];

        $recentOrganizations = Organization::withCount('activeMembers')
            ->latest()
            ->take(5)
            ->get();

        $upcomingEvents = Event::with('organization')
            ->where('status', 'upcoming')
            ->where('event_date', '>=', now())
            ->orderBy('event_date')
            ->take(5)
            ->get();

        $recentUsers = User::where('role', '!=', 'admin')
            ->with('organization')
            ->latest()
            ->take(5)
            ->get();

        $systemActivity = [
            'new_users_today' => User::whereDate('created_at', today())->count(),
            'new_organizations_week' => Organization::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
            'events_this_month' => Event::whereMonth('event_date', now()->month)->count(),
        ];
        $user = $request->user();
        $organizations = Organization::all();

        return view('dashboard.admin', compact(
            'user',
            'stats',
            'recentOrganizations',
            'upcomingEvents',
            'recentUsers',
            'systemActivity',
            'organizations'
        ));
    }

    private function organizationAdminDashboard(Request $request)
    {
        $user = $request->user();;
        $organization = $user->organization;

        if (!$organization) {
            return redirect()->route('profile.edit')
                ->with('error', 'Anda belum terdaftar dalam organisasi manapun.');
        }

        $stats = [
            'total_members' => $organization->activeMembers()->count(),
            'total_events' => $organization->events()->count(),
            'upcoming_events' => $organization->upcomingEvents()->count(),
            'total_documents' => $organization->documents()->count(),
        ];

        $recentMembers = $organization->activeMembers()
            ->latest()
            ->take(5)
            ->get();

        $upcomingEvents = $organization->upcomingEvents()
            ->orderBy('event_date')
            ->take(5)
            ->get();

        $recentDocuments = $organization->documents()
            ->where('status', 'published')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.organization-admin', compact(
            'organization',
            'stats',
            'recentMembers',
            'upcomingEvents',
            'recentDocuments'
        ));
    }

    private function memberDashboard(Request $request)
    {
        $user = $request->user();
        $organization = $user->organization;

        if (!$organization) {
            return view('dashboard.member-no-organization');
        }

        $upcomingEvents = $organization->upcomingEvents()
            ->orderBy('event_date')
            ->take(5)
            ->get();

        $recentAnnouncements = Announcement::where(function ($query) use ($organization) {
            $query->where('organization_id', $organization->id)
                ->orWhereNull('organization_id');
        })
            ->where('status', 'published')
            ->where('publish_date', '<=', now())
            ->where(function ($query) {
                $query->whereNull('expire_date')
                    ->orWhere('expire_date', '>=', now());
            })
            ->latest('publish_date')
            ->take(5)
            ->get();

        $recentDocuments = $organization->documents()
            ->where('status', 'published')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.member', compact(
            'organization',
            'upcomingEvents',
            'recentAnnouncements',
            'recentDocuments'
        ));
    }
}
