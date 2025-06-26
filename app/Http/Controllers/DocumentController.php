<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class DocumentController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $query = Document::with(['organization', 'uploader']);

        // Role-based filtering
        if ($user->isOrganizationAdmin()) {
            $query->where('organization_id', $user->organization_id);
        } elseif ($user->isMember()) {
            $query->where('organization_id', $user->organization_id)
                ->where('status', 'published');
        }

        // Search functionality
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', '%' . $searchTerm . '%')
                    ->orWhere('description', 'like', '%' . $searchTerm . '%')
                    ->orWhere('category', 'like', '%' . $searchTerm . '%');
            });
        }

        // Filter by organization (admin only)
        if ($request->filled('organization_id') && $user->isAdmin()) {
            $query->where('organization_id', $request->organization_id);
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Filter by status (not for members)
        if ($request->filled('status') && !$user->isMember()) {
            $query->where('status', $request->status);
        }

        $documents = $query->orderBy('created_at', 'desc')->paginate(12);
        $organizations = $user->isAdmin() ? Organization::where('status', 'active')->get() : collect();

        return view('documents.index', compact('documents', 'organizations'));
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

        return view('documents.create', compact('organizations', 'selectedOrgId'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        if (!$user->isAdmin() && !$user->isOrganizationAdmin()) {
            abort(403, 'Unauthorized access');
        }

        $validated = $request->validate([
            'organization_id' => 'required|exists:organizations,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'category' => 'nullable|string|max:100',
            'status' => 'required|in:draft,published,archived',
            'file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,txt|max:10240', // 10MB max
        ], [
            'file.required' => 'File dokumen wajib diupload.',
            'file.mimes' => 'Format file tidak didukung. Gunakan PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX, atau TXT.',
            'file.max' => 'Ukuran file maksimal 10MB.',
        ]);

        // Check organization access
        if ($user->isOrganizationAdmin() && $validated['organization_id'] != $user->organization_id) {
            abort(403, 'Unauthorized access to organization');
        }

        // Handle file upload
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('documents', $fileName, 'public');

            $validated['file_name'] = $file->getClientOriginalName();
            $validated['file_path'] = $filePath;
            $validated['file_size'] = $file->getSize();
            $validated['file_type'] = $file->getClientOriginalExtension();
        }

        $validated['uploaded_by'] = Auth::id();

        Document::create($validated);

        return redirect()
            ->route('documents.index', ['organization_id' => $validated['organization_id']])
            ->with('success', 'Dokumen berhasil diupload.');
    }

    public function show(Document $document)
    {
        $user = auth()->user();

        // Check access
        if ($user->isOrganizationAdmin() && $document->organization_id != $user->organization_id) {
            abort(403, 'Unauthorized access');
        } elseif ($user->isMember()) {
            if ($document->organization_id != $user->organization_id || $document->status !== 'published') {
                abort(403, 'Unauthorized access');
            }
        }

        $document->load(['organization', 'uploader']);
        return view('documents.show', compact('document'));
    }

    public function edit(Document $document)
    {
        $user = auth()->user();

        // Check access
        if ($user->isOrganizationAdmin() && $document->organization_id != $user->organization_id) {
            abort(403, 'Unauthorized access');
        } elseif (!$user->isAdmin() && !$user->isOrganizationAdmin()) {
            abort(403, 'Unauthorized access');
        }

        $organizations = $user->isAdmin() ?
            Organization::where('status', 'active')->get() :
            collect([$user->organization]);

        return view('documents.edit', compact('document', 'organizations'));
    }

    public function update(Request $request, Document $document)
    {
        $user = auth()->user();

        // Check access
        if ($user->isOrganizationAdmin() && $document->organization_id != $user->organization_id) {
            abort(403, 'Unauthorized access');
        } elseif (!$user->isAdmin() && !$user->isOrganizationAdmin()) {
            abort(403, 'Unauthorized access');
        }

        $validated = $request->validate([
            'organization_id' => 'required|exists:organizations,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'category' => 'nullable|string|max:100',
            'status' => 'required|in:draft,published,archived',
            'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,txt|max:10240',
        ]);

        // Check organization access for update
        if ($user->isOrganizationAdmin() && $validated['organization_id'] != $user->organization_id) {
            abort(403, 'Unauthorized access to organization');
        }

        // Handle file upload if new file provided
        if ($request->hasFile('file')) {
            // Delete old file
            if ($document->file_path) {
                Storage::disk('public')->delete($document->file_path);
            }

            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('documents', $fileName, 'public');

            $validated['file_name'] = $file->getClientOriginalName();
            $validated['file_path'] = $filePath;
            $validated['file_size'] = $file->getSize();
            $validated['file_type'] = $file->getClientOriginalExtension();
        }

        $document->update($validated);

        return redirect()
            ->route('documents.show', $document)
            ->with('success', 'Dokumen berhasil diperbarui.');
    }

    public function destroy(Document $document)
    {
        $user = auth()->user();

        // Check access
        if ($user->isOrganizationAdmin() && $document->organization_id != $user->organization_id) {
            abort(403, 'Unauthorized access');
        } elseif (!$user->isAdmin() && !$user->isOrganizationAdmin()) {
            abort(403, 'Unauthorized access');
        }

        try {
            // Delete file if exists
            if ($document->file_path) {
                Storage::disk('public')->delete($document->file_path);
            }

            $documentTitle = $document->title;
            $document->delete();

            return redirect()
                ->route('documents.index')
                ->with('success', "Dokumen '{$documentTitle}' berhasil dihapus.");
        } catch (\Exception $e) {
            return redirect()
                ->route('documents.show', $document)
                ->with('error', 'Gagal menghapus dokumen. Silakan coba lagi.');
        }
    }

    public function download(Document $document)
    {
        $user = auth()->user();

        // Check access
        if ($user->isOrganizationAdmin() && $document->organization_id != $user->organization_id) {
            abort(403, 'Unauthorized access');
        } elseif ($user->isMember()) {
            if ($document->organization_id != $user->organization_id || $document->status !== 'published') {
                abort(403, 'Unauthorized access');
            }
        }

        if (!$document->file_path || !Storage::disk('public')->exists($document->file_path)) {
            abort(404, 'File tidak ditemukan.');
        }

        return Storage::disk('public')->download($document->file_path, $document->file_name);
    }
}
