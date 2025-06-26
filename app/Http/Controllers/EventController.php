<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::with('organization');

        // Search
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhereHas('organization', function($orgQuery) use ($request) {
                      $orgQuery->where('name', 'like', '%' . $request->search . '%');
                  });
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by organization
        if ($request->filled('organization_id')) {
            $query->where('organization_id', $request->organization_id);
        }

        $events = $query->orderBy('event_date', 'desc')->paginate(12);
        $organizations = Organization::where('status', 'active')->get();

        return view('events.index', compact('events', 'organizations'));
    }

    public function create()
    {
        $organizations = Organization::where('status', 'active')->get();
        return view('events.create', compact('organizations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'organization_id' => 'required|exists:organizations,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:100',
            'event_date' => 'required|date|after_or_equal:today',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after:start_time',
            'location' => 'nullable|string|max:255',
            'max_participants' => 'nullable|integer|min:1',
            'registration_deadline' => 'nullable|date|before_or_equal:event_date',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        if ($request->hasFile('poster')) {
            $validated['poster_path'] = $request->file('poster')->store('events/posters', 'public');
        }

        $validated['created_by'] = Auth::id();

        Event::create($validated);

        return redirect()->route('events.index')
            ->with('success', 'Event berhasil dibuat.');
    }

    public function show(Event $event)
    {
        $event->load('organization', 'creator');
        return view('events.show', compact('event'));
    }

    public function edit(Event $event)
    {
        $organizations = Organization::where('status', 'active')->get();
        return view('events.edit', compact('event', 'organizations'));
    }

    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'organization_id' => 'required|exists:organizations,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:100',
            'event_date' => 'required|date',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after:start_time',
            'location' => 'nullable|string|max:255',
            'max_participants' => 'nullable|integer|min:1',
            'status' => 'required|in:upcoming,ongoing,completed,cancelled',
            'registration_deadline' => 'nullable|date|before_or_equal:event_date',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        if ($request->hasFile('poster')) {
            if ($event->poster_path) {
                Storage::disk('public')->delete($event->poster_path);
            }
            $validated['poster_path'] = $request->file('poster')->store('events/posters', 'public');
        }

        $event->update($validated);

        return redirect()->route('events.show', $event)
            ->with('success', 'Event berhasil diperbarui.');
    }

    public function destroy(Event $event)
    {
        if ($event->poster_path) {
            Storage::disk('public')->delete($event->poster_path);
        }

        $event->delete();

        return redirect()->route('events.index')
            ->with('success', 'Event berhasil dihapus.');
    }
}
