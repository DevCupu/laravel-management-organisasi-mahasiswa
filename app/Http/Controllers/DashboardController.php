<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\Member;
use App\Models\Event;
use App\Models\Document;
use App\Models\Announcement;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // $stats = [
        //     'total_organizations' => Organization::count(),
        //     'total_members' => Member::where('status', 'active')->count(),
        //     'total_events' => Event::whereMonth('event_date', now()->month)->count(),
        //     'active_events' => Event::where('status', 'upcoming')->count(),
        // ];

        $recentOrganizations = Organization::with('activeMembers')
            ->latest()
            ->take(5)
            ->get();

        // $upcomingEvents = Event::with('organization')
        //     ->where('status', 'upcoming')
        //     ->where('event_date', '>=', now())
        //     ->orderBy('event_date')
        //     ->take(5)
        //     ->get();

        // $recentAnnouncements = Announcement::with('organization')
        //     ->where('status', 'published')
        //     ->where('publish_date', '<=', now())
        //     ->where(function ($query) {
        //         $query->whereNull('expire_date')
        //             ->orWhere('expire_date', '>=', now());
        //     })
        //     ->latest('publish_date')
        //     ->take(5)
        //     ->get();

        return view('dashboard', compact(
            // 'stats',
            'recentOrganizations',
            // 'upcomingEvents',
            // 'recentAnnouncements'
        ));
    }
}
