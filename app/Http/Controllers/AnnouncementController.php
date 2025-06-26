<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnnouncementController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $query = Announcement::with('organization');

        // Role-based filtering
        if ($user->isOrganizationAdmin()) {
            $query->where(function ($q) use ($user) {
                $q->where('organization_id', $user->organization_id)
                    ->orWhereNull('organization_id'); // Global announcements
            });
        } elseif ($user->isMember()) {
            $query->where(function ($q) use ($user) {
                $q->where('organization_id', $user->organization_id)
                    ->orWhereNull('organization_id'); // Global announcements
            })
                ->where('status', 'published')
                ->where('publish_date', '<=', now())
                ->where(function ($q) {
                    $q->whereNull('expire_date')
                        ->orWhere('expire_date', '>=', now());
                });
        }

        // Search functionality
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', '%' . $searchTerm . '%')
                    ->orWhere('content', 'like', '%' . $searchTerm . '%');
            });
        }

        // Filter by organization (admin only)
        if ($request->filled('organization_id') && $user->isAdmin()) {
            if ($request->organization_id === 'global') {
                $query->whereNull('organization_id');
            } else {
                $query->where('organization_id', $request->organization_id);
            }
        }

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filter by status (not for members)
        if ($request->filled('status') && !$user->isMember()) {
            $query->where('status', $request->status);
        }

        $announcements = $query->orderBy('publish_date', 'desc')->paginate(10);
        $organizations = $user->isAdmin() ? Organization::where('status', 'active')->get() : collect();

        return view('announcements.index', compact('announcements', 'organizations'));
    }

    public function create(Request $request)
    {
        $user = auth()->user();

        if (!$user->isAdmin() && !$user->isOrganizationAdmin()) {
            abort(403, 'Unauthorized access');
        }

        $organizations = collect();
        $selectedOrgId = null;

        if ($user->isAdmin()) {
            $organizations = Organization::where('status', 'active')->get();
            $selectedOrgId = $request->get('organization_id');
        } elseif ($user->isOrganizationAdmin()) {
            $organizations = collect([$user->organization]);
            $selectedOrgId = $user->organization_id;
        }

        return view('announcements.create', compact('organizations', 'selectedOrgId'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        if (!$user->isAdmin() && !$user->isOrganizationAdmin()) {
            abort(403, 'Unauthorized access');
        }

        $validated = $request->validate([
            'organization_id' => 'nullable|exists:organizations,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'type' => 'required|in:general,urgent,event,academic',
            'status' => 'required|in:draft,published,archived',
            'publish_date' => 'required|date|after_or_equal:today',
            'expire_date' => 'nullable|date|after:publish_date',
        ], [
            'publish_date.after_or_equal' => 'Tanggal publikasi tidak boleh di masa lalu.',
            'expire_date.after' => 'Tanggal kadaluarsa harus setelah tanggal publikasi.',
        ]);

        // Check organization access
        if ($user->isOrganizationAdmin()) {
            if ($validated['organization_id'] && $validated['organization_id'] != $user->organization_id) {
                abort(403, 'Unauthorized access to organization');
            }
            // Force organization admin to only create for their organization
            $validated['organization_id'] = $user->organization_id;
        }

        // Only admin can create global announcements
        if (!$validated['organization_id'] && !$user->isAdmin()) {
            abort(403, 'Only system admin can create global announcements');
        }

        $validated['created_by'] = Auth::id();

        Announcement::create($validated);

        return redirect()
            ->route('announcements.index')
            ->with('success', 'Pengumuman berhasil dibuat.');
    }

    public function show(Announcement $announcement)
    {
        $user = auth()->user();

        // Check access
        if ($user->isOrganizationAdmin()) {
            if ($announcement->organization_id && $announcement->organization_id != $user->organization_id) {
                abort(403, 'Unauthorized access');
            }
        } elseif ($user->isMember()) {
            if ($announcement->organization_id && $announcement->organization_id != $user->organization_id) {
                abort(403, 'Unauthorized access');
            }
            if (
                $announcement->status !== 'published' ||
                $announcement->publish_date > now() ||
                ($announcement->expire_date && $announcement->expire_date < now())
            ) {
                abort(403, 'Announcement not available');
            }
        }

        $announcement->load('organization');
        return view('announcements.show', compact('announcement'));
    }

    public function edit(Announcement $announcement)
    {
        $user = auth()->user();

        // Check access
        if ($user->isOrganizationAdmin()) {
            if ($announcement->organization_id != $user->organization_id) {
                abort(403, 'Unauthorized access');
            }
        } elseif (!$user->isAdmin()) {
            abort(403, 'Unauthorized access');
        }

        $organizations = collect();

        if ($user->isAdmin()) {
            $organizations = Organization::where('status', 'active')->get();
        } elseif ($user->isOrganizationAdmin()) {
            $organizations = collect([$user->organization]);
        }

        return view('announcements.edit', compact('announcement', 'organizations'));
    }

    public function update(Request $request, Announcement $announcement)
    {
        $user = auth()->user();

        // Check access
        if ($user->isOrganizationAdmin()) {
            if ($announcement->organization_id != $user->organization_id) {
                abort(403, 'Unauthorized access');
            }
        } elseif (!$user->isAdmin()) {
            abort(403, 'Unauthorized access');
        }

        $validated = $request->validate([
            'organization_id' => 'nullable|exists:organizations,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'type' => 'required|in:general,urgent,event,academic',
            'status' => 'required|in:draft,published,archived',
            'publish_date' => 'required|date',
            'expire_date' => 'nullable|date|after:publish_date',
        ]);

        // Check organization access for update
        if ($user->isOrganizationAdmin()) {
            if ($validated['organization_id'] && $validated['organization_id'] != $user->organization_id) {
                abort(403, 'Unauthorized access to organization');
            }
            $validated['organization_id'] = $user->organization_id;
        }

        // Only admin can create/edit global announcements
        if (!$validated['organization_id'] && !$user->isAdmin()) {
            abort(403, 'Only system admin can create global announcements');
        }

        $announcement->update($validated);

        return redirect()
            ->route('announcements.show', $announcement)
            ->with('success', 'Pengumuman berhasil diperbarui.');
    }

    public function destroy(Announcement $announcement)
    {
        $user = auth()->user();

        // Check access
        if ($user->isOrganizationAdmin()) {
            if ($announcement->organization_id != $user->organization_id) {
                abort(403, 'Unauthorized access');
            }
        } elseif (!$user->isAdmin()) {
            abort(403, 'Unauthorized access');
        }

        try {
            $announcementTitle = $announcement->title;
            $announcement->delete();

            return redirect()
                ->route('announcements.index')
                ->with('success', "Pengumuman '{$announcementTitle}' berhasil dihapus.");
        } catch (\Exception $e) {
            return redirect()
                ->route('announcements.show', $announcement)
                ->with('error', 'Gagal menghapus pengumuman. Silakan coba lagi.');
        }
    }
}
