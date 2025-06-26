<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class OrganizationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Organization::withCount(['activeMembers', 'events', 'documents']);

        // Search functionality
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('acronym', 'like', '%' . $searchTerm . '%')
                    ->orWhere('description', 'like', '%' . $searchTerm . '%');
            });
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');

        $allowedSortFields = ['name', 'acronym', 'category', 'status', 'created_at', 'updated_at'];
        if (in_array($sortBy, $allowedSortFields)) {
            $query->orderBy($sortBy, $sortOrder);
        }

        $organizations = $query->paginate(12)->appends($request->query());

        return view('organizations.index', compact('organizations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('organizations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'acronym' => 'required|string|max:50|unique:organizations,acronym',
            'category' => 'required|in:himpunan,ukm,ormawa,bem,osis',
            'description' => 'nullable|string|max:1000',
            'established_date' => 'nullable|date|before_or_equal:today',
            'status' => 'required|in:active,inactive',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'website' => 'nullable|url|max:255',
            'social_media' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:500',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB max
        ], [
            'name.required' => 'Nama organisasi wajib diisi.',
            'acronym.required' => 'Akronim organisasi wajib diisi.',
            'acronym.unique' => 'Akronim ini sudah digunakan oleh organisasi lain.',
            'category.required' => 'Kategori organisasi wajib dipilih.',
            'category.in' => 'Kategori yang dipilih tidak valid.',
            'established_date.before_or_equal' => 'Tanggal berdiri tidak boleh di masa depan.',
            'email.email' => 'Format email tidak valid.',
            'website.url' => 'Format website tidak valid.',
            'logo.image' => 'File logo harus berupa gambar.',
            'logo.mimes' => 'Logo harus berformat JPEG, PNG, JPG, atau GIF.',
            'logo.max' => 'Ukuran logo maksimal 2MB.',
        ]);

        // Handle logo upload
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('organizations/logos', 'public');
            $validated['logo_path'] = $logoPath;
        }

        $organization = Organization::create($validated);

        return redirect()
            ->route('organizations.show', $organization)
            ->with('success', 'Organisasi berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Organization $organization)
    {
        $organization->loadCount(['activeMembers', 'events', 'documents']);
        $organization->load([
            'activeMembers' => function ($query) {
                $query->latest()->take(5);
            },
            'upcomingEvents' => function ($query) {
                $query->where('event_date', '>=', now())
                    ->orderBy('event_date')
                    ->take(3);
            }
        ]);

        return view('organizations.show', compact('organization'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Organization $organization)
    {
        return view('organizations.edit', compact('organization'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Organization $organization)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'acronym' => [
                'required',
                'string',
                'max:50',
                Rule::unique('organizations', 'acronym')->ignore($organization->id)
            ],
            'category' => 'required|in:himpunan,ukm,ormawa,bem,osis',
            'description' => 'nullable|string|max:1000',
            'established_date' => 'nullable|date|before_or_equal:today',
            'status' => 'required|in:active,inactive',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'website' => 'nullable|url|max:255',
            'social_media' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:500',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'name.required' => 'Nama organisasi wajib diisi.',
            'acronym.required' => 'Akronim organisasi wajib diisi.',
            'acronym.unique' => 'Akronim ini sudah digunakan oleh organisasi lain.',
            'category.required' => 'Kategori organisasi wajib dipilih.',
            'category.in' => 'Kategori yang dipilih tidak valid.',
            'established_date.before_or_equal' => 'Tanggal berdiri tidak boleh di masa depan.',
            'email.email' => 'Format email tidak valid.',
            'website.url' => 'Format website tidak valid.',
            'logo.image' => 'File logo harus berupa gambar.',
            'logo.mimes' => 'Logo harus berformat JPEG, PNG, JPG, atau GIF.',
            'logo.max' => 'Ukuran logo maksimal 2MB.',
        ]);

        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($organization->logo_path) {
                Storage::disk('public')->delete($organization->logo_path);
            }

            $logoPath = $request->file('logo')->store('organizations/logos', 'public');
            $validated['logo_path'] = $logoPath;
        }

        $organization->update($validated);

        return redirect()
            ->route('organizations.show', $organization)
            ->with('success', 'Organisasi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Organization $organization)
    {
        try {
            // Delete logo file if exists
            if ($organization->logo_path) {
                Storage::disk('public')->delete($organization->logo_path);
            }

            // Delete the organization (cascade will handle related records)
            $organizationName = $organization->name;
            $organization->delete();

            return redirect()
                ->route('organizations.index')
                ->with('success', "Organisasi '{$organizationName}' berhasil dihapus.");
        } catch (\Exception $e) {
            return redirect()
                ->route('organizations.show', $organization)
                ->with('error', 'Gagal menghapus organisasi. Silakan coba lagi.');
        }
    }

    /**
     * Get organizations for API or AJAX requests
     */
    public function getOrganizations(Request $request)
    {
        $query = Organization::select('id', 'name', 'acronym', 'logo_path')
            ->where('status', 'active');

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('acronym', 'like', '%' . $searchTerm . '%');
            });
        }

        $organizations = $query->orderBy('name')->get();

        return response()->json([
            'success' => true,
            'data' => $organizations->map(function ($org) {
                return [
                    'id' => $org->id,
                    'name' => $org->name,
                    'acronym' => $org->acronym,
                    'logo_url' => $org->logo_path ? Storage::url($org->logo_path) : null,
                ];
            })
        ]);
    }
}
