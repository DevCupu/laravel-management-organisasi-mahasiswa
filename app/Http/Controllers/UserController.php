<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

use Illuminate\Routing\Controller as BaseController;

class UserController extends BaseController
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    public function index(Request $request)
    {
        $query = User::with('organization')->where('role', '!=', 'admin');

        // Search functionality
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('email', 'like', '%' . $searchTerm . '%')
                    ->orWhere('student_id', 'like', '%' . $searchTerm . '%');
            });
        }

        // Filter by role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Filter by organization
        if ($request->filled('organization_id')) {
            $query->where('organization_id', $request->organization_id);
        }

        // Filter by status
        if ($request->filled('status')) {
            $isActive = $request->status === 'active';
            $query->where('is_active', $isActive);
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(15);
        $organizations = Organization::where('status', 'active')->get();

        return view('users.index', compact('users', 'organizations'));
    }

    public function create()
    {
        $organizations = Organization::where('status', 'active')->get();
        return view('users.create', compact('organizations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:organization_admin,member',
            'organization_id' => 'required|exists:organizations,id',
            'student_id' => 'nullable|string|max:50',
            'phone' => 'nullable|string|max:20',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.unique' => 'Email sudah digunakan.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'role.required' => 'Role wajib dipilih.',
            'organization_id.required' => 'Organisasi wajib dipilih.',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()
            ->route('users.index')
            ->with('success', 'User berhasil ditambahkan.');
    }

    public function show(User $user)
    {
        if ($user->role === 'admin') {
            abort(403, 'Tidak dapat melihat data admin.');
        }

        $user->load('organization');
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        if ($user->role === 'admin') {
            abort(403, 'Tidak dapat mengedit data admin.');
        }

        $organizations = Organization::where('status', 'active')->get();
        return view('users.edit', compact('user', 'organizations'));
    }

    public function update(Request $request, User $user)
    {
        if ($user->role === 'admin') {
            abort(403, 'Tidak dapat mengedit data admin.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:organization_admin,member',
            'organization_id' => 'required|exists:organizations,id',
            'student_id' => 'nullable|string|max:50',
            'phone' => 'nullable|string|max:20',
            'is_active' => 'boolean',
        ]);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()
            ->route('users.show', $user)
            ->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->role === 'admin') {
            abort(403, 'Tidak dapat menghapus data admin.');
        }

        $userName = $user->name;
        $user->delete();

        return redirect()
            ->route('users.index')
            ->with('success', "User '{$userName}' berhasil dihapus.");
    }

    public function toggleStatus(User $user)
    {
        if ($user->role === 'admin') {
            abort(403, 'Tidak dapat mengubah status admin.');
        }

        $user->update(['is_active' => !$user->is_active]);

        $status = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return redirect()
            ->back()
            ->with('success', "User '{$user->name}' berhasil {$status}.");
    }
}
