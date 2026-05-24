<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Domination;
use App\Models\Battalion;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewAnnouncementNotification;

class AnnouncementController extends Controller
{
    /**
     * Display announcements visible to the current user.
     */
    public function index(Request $request)
    {
        \Illuminate\Support\Facades\Gate::authorize('viewAny', Announcement::class);
        $user = Auth::user();
        $query = Announcement::with('creator')->latest();

        if ($user->hasRole('Super Admin')) {
            // Sees everything
        } elseif ($user->hasRole('Domination Admin') && $user->domination_id) {
            $query->where(function ($q) use ($user) {
                $q->where('visibility_level', 'national')
                  ->orWhere(function ($q2) use ($user) {
                      $q2->where('visibility_level', 'domination')
                         ->where('entity_id', $user->domination_id);
                  })
                  ->orWhere(function ($q2) use ($user) {
                      $battalionIds = Battalion::where('domination_id', $user->domination_id)->pluck('id');
                      $q2->where('visibility_level', 'battalion')
                         ->whereIn('entity_id', $battalionIds);
                  });
            });
        } elseif ($user->hasRole('Battalion Commander') && $user->battalion_id) {
            $query->where(function ($q) use ($user) {
                $q->where('visibility_level', 'national')
                  ->orWhere(function ($q2) use ($user) {
                      $battalion = Battalion::find($user->battalion_id);
                      $q2->where('visibility_level', 'domination')
                         ->where('entity_id', $battalion?->domination_id);
                  })
                  ->orWhere(function ($q2) use ($user) {
                      $q2->where('visibility_level', 'battalion')
                         ->where('entity_id', $user->battalion_id);
                  })
                  ->orWhere(function ($q2) use ($user) {
                      $companyIds = Company::where('battalion_id', $user->battalion_id)->pluck('id');
                      $q2->where('visibility_level', 'company')
                         ->whereIn('entity_id', $companyIds);
                  });
            });
        } elseif (($user->hasRole('Company Captain') || $user->hasRole('Company Officer') || $user->hasRole('Member')) && $user->company_id) {
            $company = Company::find($user->company_id);
            $battalion = $company?->battalion;
            $query->where(function ($q) use ($user, $company, $battalion) {
                $q->where('visibility_level', 'national')
                  ->orWhere(function ($q2) use ($battalion) {
                      if ($battalion) {
                          $q2->where('visibility_level', 'domination')
                             ->where('entity_id', $battalion->domination_id);
                      }
                  })
                  ->orWhere(function ($q2) use ($user, $company) {
                      if ($company) {
                          $q2->where('visibility_level', 'battalion')
                             ->where('entity_id', $company->battalion_id);
                      }
                  })
                  ->orWhere(function ($q2) use ($user) {
                      $q2->where('visibility_level', 'company')
                         ->where('entity_id', $user->company_id);
                  });
            });
        } else {
            // Fallback: national only
            $query->where('visibility_level', 'national');
        }

        // Filter by level
        if ($request->filled('level')) {
            $query->where('visibility_level', $request->level);
        }

        $announcements = $query->paginate(12);
        return view('announcements.index', compact('announcements'));
    }

    /**
     * Show the form for creating a new announcement.
     */
    public function create()
    {
        \Illuminate\Support\Facades\Gate::authorize('create', Announcement::class);
        $user = Auth::user();
        $levels = $this->getAllowedLevels($user);
        $dominations = Domination::orderBy('name')->get();
        $battalions = Battalion::with('domination')->orderBy('name')->get();
        $companies = Company::with('battalion')->orderBy('name')->get();

        return view('announcements.create', compact('levels', 'dominations', 'battalions', 'companies'));
    }

    /**
     * Store a newly created announcement.
     */
    public function store(Request $request)
    {
        \Illuminate\Support\Facades\Gate::authorize('create', Announcement::class);
        $user = Auth::user();
        $levels = $this->getAllowedLevels($user);

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'visibility_level' => 'required|in:' . implode(',', $levels),
            'entity_id' => 'nullable|uuid',
        ]);

        // Validate entity_id matches the level
        $entityId = null;
        $level = $request->visibility_level;

        if ($level === 'national') {
            $entityId = null;
        } elseif ($level === 'domination') {
            $entityId = $request->entity_id;
            if (!$entityId && $user->domination_id) {
                $entityId = $user->domination_id;
            }
        } elseif ($level === 'battalion') {
            $entityId = $request->entity_id;
            if (!$entityId && $user->battalion_id) {
                $entityId = $user->battalion_id;
            }
        } elseif ($level === 'company') {
            $entityId = $request->entity_id;
            if (!$entityId && $user->company_id) {
                $entityId = $user->company_id;
            }
        }

        $announcement = Announcement::create([
            'title' => $request->title,
            'content' => $request->content,
            'visibility_level' => $level,
            'entity_id' => $entityId,
            'created_by' => $user->id,
        ]);

        // Send Notification
        $usersQuery = User::query()->where('is_approved', true);
        if ($level === 'domination') {
            $usersQuery->where('domination_id', $entityId);
        } elseif ($level === 'battalion') {
            $usersQuery->where('battalion_id', $entityId);
        } elseif ($level === 'company') {
            $usersQuery->where('company_id', $entityId);
        }

        Notification::send($usersQuery->get(), new NewAnnouncementNotification($announcement));

        return redirect()->route('announcements.index')->with('success', 'Announcement created successfully.');
    }

    /**
     * Display the specified announcement.
     */
    public function show(Announcement $announcement)
    {
        \Illuminate\Support\Facades\Gate::authorize('view', $announcement);
        $announcement->load('creator');
        return view('announcements.show', compact('announcement'));
    }

    /**
     * Show the form for editing the specified announcement.
     */
    public function edit(Announcement $announcement)
    {
        \Illuminate\Support\Facades\Gate::authorize('update', $announcement);
        $user = Auth::user();
        $levels = $this->getAllowedLevels($user);
        $dominations = Domination::orderBy('name')->get();
        $battalions = Battalion::with('domination')->orderBy('name')->get();
        $companies = Company::with('battalion')->orderBy('name')->get();

        return view('announcements.edit', compact('announcement', 'levels', 'dominations', 'battalions', 'companies'));
    }

    /**
     * Update the specified announcement.
     */
    public function update(Request $request, Announcement $announcement)
    {
        \Illuminate\Support\Facades\Gate::authorize('update', $announcement);
        $user = Auth::user();
        $levels = $this->getAllowedLevels($user);

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'visibility_level' => 'required|in:' . implode(',', $levels),
            'entity_id' => 'nullable|uuid',
        ]);

        $entityId = null;
        $level = $request->visibility_level;

        if ($level === 'domination') {
            $entityId = $request->entity_id ?: $user->domination_id;
        } elseif ($level === 'battalion') {
            $entityId = $request->entity_id ?: $user->battalion_id;
        } elseif ($level === 'company') {
            $entityId = $request->entity_id ?: $user->company_id;
        }

        $announcement->update([
            'title' => $request->title,
            'content' => $request->content,
            'visibility_level' => $level,
            'entity_id' => $entityId,
        ]);

        return redirect()->route('announcements.show', $announcement)->with('success', 'Announcement updated successfully.');
    }

    /**
     * Remove the specified announcement.
     */
    public function destroy(Announcement $announcement)
    {
        \Illuminate\Support\Facades\Gate::authorize('delete', $announcement);
        $announcement->delete();
        return redirect()->route('announcements.index')->with('success', 'Announcement deleted successfully.');
    }

    /**
     * Determine which visibility levels the current user can create announcements for.
     */
    private function getAllowedLevels($user): array
    {
        if ($user->hasRole('Super Admin')) {
            return ['national', 'domination', 'battalion', 'company'];
        } elseif ($user->hasRole('Domination Admin')) {
            return ['domination', 'battalion'];
        } elseif ($user->hasRole('Battalion Commander')) {
            return ['battalion', 'company'];
        } elseif ($user->hasRole('Company Captain')) {
            return ['company'];
        }
        return [];
    }
}
