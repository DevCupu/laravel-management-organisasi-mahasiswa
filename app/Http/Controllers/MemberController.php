<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class MemberController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = $request->user();

        $query = Member::with('organization');

        // Role-based filtering
        if ($user->role === 'organization_admin') {
            $query->where('organization_id', $user->organization_id);
        } elseif ($user->role === 'member') {
            $query->where('organization_id', $user->organization_id);
        }

        // Search functionality
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('email', 'like', '%' . $searchTerm . '%')
                    ->orWhere('student_id', 'like', '%' . $searchTerm . '%')
                    ->orWhere('position', 'like', '%' . $searchTerm . '%');
            });
        }

        // Filter by organization
        if ($request->filled('organization_id') && $user->role === 'admin') {
            $query->where('organization_id', $request->organization_id);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by position
        if ($request->filled('position')) {
            $query->where('position', 'like', '%' . $request->position . '%');
        }

        $members = $query->orderBy('created_at', 'desc')->paginate(15);
        $organizations = Organization::where('status', 'active')->get();

        return view('members.index', compact('members', 'organizations'));
    }

    public function create(Request $request)
    {
        $user = $request->user();

        if ($user->role === 'admin') {
            $organizations = Organization::where('status', 'active')->get();
        } else {
            $organizations = collect([$user->organization]);
        }

        return view('members.create', compact('organizations'));
    }

    public function store(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'organization_id' => 'required|exists:organizations,id',
            'student_id' => 'required|string|max:50|unique:members,student_id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:members,email',
            'phone' => 'nullable|string|max:20',
            'position' => 'required|string|max:100',
            'join_date' => 'required|date',
            'status' => 'required|in:active,inactive,alumni',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Check organization access
        if ($user->role === 'organization_admin' && $validated['organization_id'] != $user->organization_id) {
            abort(403, 'Anda tidak dapat menambah anggota ke organisasi lain.');
        }

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('members/photos', 'public');
        }

        Member::create($validated);

        return redirect()
            ->route('members.index')
            ->with('success', 'Anggota berhasil ditambahkan.');
    }

    public function show(Request $request, Member $member)
    {
        $user = $request->user();

        // Check access
        if ($user->role !== 'admin' && $member->organization_id !== $user->organization_id) {
            abort(403, 'Anda tidak dapat melihat anggota organisasi lain.');
        }

        $member->load('organization');
        $userAccount = User::where('email', $member->email)->first();

        return view('members.show', compact('member', 'userAccount'));
    }

    public function edit(Request $request, Member $member)
    {
        $user = $request->user();

        // Check access
        if ($user->role !== 'admin' && $member->organization_id !== $user->organization_id) {
            abort(403, 'Anda tidak dapat mengedit anggota organisasi lain.');
        }

        if ($user->role === 'admin') {
            $organizations = Organization::where('status', 'active')->get();
        } else {
            $organizations = collect([$user->organization]);
        }

        return view('members.edit', compact('member', 'organizations'));
    }

    public function update(Request $request, Member $member)
    {
        $user = $request->user();

        // Check access
        if ($user->role !== 'admin' && $member->organization_id !== $user->organization_id) {
            abort(403, 'Anda tidak dapat mengedit anggota organisasi lain.');
        }

        $validated = $request->validate([
            'organization_id' => 'required|exists:organizations,id',
            'student_id' => ['required', 'string', 'max:50', Rule::unique('members')->ignore($member->id)],
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('members')->ignore($member->id)],
            'phone' => 'nullable|string|max:20',
            'position' => 'required|string|max:100',
            'join_date' => 'required|date',
            'status' => 'required|in:active,inactive,alumni',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Check organization access
        if ($user->role === 'organization_admin' && $validated['organization_id'] != $user->organization_id) {
            abort(403, 'Anda tidak dapat memindah anggota ke organisasi lain.');
        }

        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo
            if ($member->photo) {
                Storage::disk('public')->delete($member->photo);
            }
            $validated['photo'] = $request->file('photo')->store('members/photos', 'public');
        }

        $member->update($validated);

        return redirect()
            ->route('members.show', $member)
            ->with('success', 'Data anggota berhasil diperbarui.');
    }

    public function destroy(Request $request, Member $member)
    {
        $user = $request->user();

        // Check access
        if ($user->role !== 'admin' && $member->organization_id !== $user->organization_id) {
            abort(403, 'Anda tidak dapat menghapus anggota organisasi lain.');
        }

        $memberName = $member->name;

        // Delete photo if exists
        if ($member->photo) {
            Storage::disk('public')->delete($member->photo);
        }

        $member->delete();

        return redirect()
            ->route('members.index')
            ->with('success', "Anggota '{$memberName}' berhasil dihapus.");
    }

    public function createUserAccount(Request $request, Member $member)
    {
        $user = $request->user();

        // Check access
        if ($user->role !== 'admin' && $member->organization_id !== $user->organization_id) {
            abort(403, 'Anda tidak dapat membuat akun untuk anggota organisasi lain.');
        }

        // Check if user account already exists
        if (User::where('email', $member->email)->exists()) {
            return redirect()
                ->back()
                ->with('error', 'Akun user dengan email ini sudah ada.');
        }

        User::create([
            'name' => $member->name,
            'email' => $member->email,
            'password' => Hash::make('password'),
            'role' => 'member',
            'organization_id' => $member->organization_id,
            'student_id' => $member->student_id,
            'phone' => $member->phone,
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        return redirect()
            ->back()
            ->with('success', 'Akun user berhasil dibuat dengan password default: password');
    }
}
