<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Denomination;
use App\Models\Battalion;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewAnnouncementNotification;

class AnnouncementController extends Controller
{
    /**
     * Display announcements visible to the current user.
     */
    public function index(Request $request)
    {
        Gate::authorize('viewAny', Announcement::class);
        $user = Auth::user();
        $query = Announcement::with(['creator', 'approver'])->latest();

        if (!$user->can('approve announcements')) {
            $query->where(function ($q) use ($user) {
                $q->where('is_approved', true)
                  ->orWhere('created_by', $user->id);
            });
        }

        if ($user->hasRole('Super Admin')) {
            // Sees everything
        } elseif ($user->hasRole('Denomination Admin') && $user->denomination_id) {
            $domId = $user->denomination_id;
            $query->where(function ($q) use ($domId) {
                $q->where('visibility_level', 'national')
                  ->orWhere(function ($q2) use ($domId) {
                      $q2->where('visibility_level', 'denomination')
                         ->where(function ($q3) use ($domId) {
                             $q3->whereJsonContains('entity_ids', $domId)
                                ->orWhere('entity_id', $domId);
                         });
                  })
                  ->orWhere(function ($q2) use ($domId) {
                      $battalionIds = Battalion::where('denomination_id', $domId)->pluck('id')->toArray();
                      $q2->where('visibility_level', 'battalion')
                         ->where(function ($q3) use ($battalionIds) {
                             foreach ($battalionIds as $bid) {
                                 $q3->orWhereJsonContains('entity_ids', $bid);
                             }
                             $q3->orWhereIn('entity_id', $battalionIds); // legacy
                         });
                  });
            });
        } elseif ($user->hasRole('Battalion Commander') && $user->battalion_id) {
            $btnId = $user->battalion_id;
            $battalion = Battalion::find($btnId);
            $domId = $battalion?->denomination_id;
            
            $query->where(function ($q) use ($btnId, $domId) {
                $q->where('visibility_level', 'national')
                  ->orWhere(function ($q2) use ($domId) {
                      if ($domId) {
                          $q2->where('visibility_level', 'denomination')
                             ->where(function ($q3) use ($domId) {
                                 $q3->whereJsonContains('entity_ids', $domId)
                                    ->orWhere('entity_id', $domId);
                             });
                      }
                  })
                  ->orWhere(function ($q2) use ($btnId) {
                      $q2->where('visibility_level', 'battalion')
                         ->where(function ($q3) use ($btnId) {
                             $q3->whereJsonContains('entity_ids', $btnId)
                                ->orWhere('entity_id', $btnId);
                         });
                  })
                  ->orWhere(function ($q2) use ($btnId) {
                      $companyIds = Company::where('battalion_id', $btnId)->pluck('id')->toArray();
                      $q2->where('visibility_level', 'company')
                         ->where(function ($q3) use ($companyIds) {
                             foreach ($companyIds as $cid) {
                                 $q3->orWhereJsonContains('entity_ids', $cid);
                             }
                             $q3->orWhereIn('entity_id', $companyIds); // legacy
                         });
                  });
            });
        } elseif (($user->hasRole('Company Captain') || $user->hasRole('Company Officer') || $user->hasRole('Member')) && $user->company_id) {
            $company = Company::find($user->company_id);
            $battalion = $company?->battalion;
            $domId = $battalion?->denomination_id;
            $btnId = $company?->battalion_id;
            $cmpId = $user->company_id;

            $query->where(function ($q) use ($domId, $btnId, $cmpId) {
                $q->where('visibility_level', 'national')
                  ->orWhere(function ($q2) use ($domId) {
                      if ($domId) {
                          $q2->where('visibility_level', 'denomination')
                             ->where(function ($q3) use ($domId) {
                                 $q3->whereJsonContains('entity_ids', $domId)
                                    ->orWhere('entity_id', $domId);
                             });
                      }
                  })
                  ->orWhere(function ($q2) use ($btnId) {
                      if ($btnId) {
                          $q2->where('visibility_level', 'battalion')
                             ->where(function ($q3) use ($btnId) {
                                 $q3->whereJsonContains('entity_ids', $btnId)
                                    ->orWhere('entity_id', $btnId);
                             });
                      }
                  })
                  ->orWhere(function ($q2) use ($cmpId) {
                      $q2->where('visibility_level', 'company')
                         ->where(function ($q3) use ($cmpId) {
                             $q3->whereJsonContains('entity_ids', $cmpId)
                                ->orWhere('entity_id', $cmpId);
                         });
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
        Gate::authorize('create', Announcement::class);
        $user = Auth::user();
        $levels = $this->getAllowedLevels($user);
        $denominations = Denomination::orderBy('name')->get();
        $battalions = Battalion::with('denomination')->orderBy('name')->get();
        $companies = Company::with('battalion')->orderBy('name')->get();

        return view('announcements.create', compact('levels', 'denominations', 'battalions', 'companies'));
    }

    /**
     * Store a newly created announcement.
     */
    public function store(Request $request)
    {
        Gate::authorize('create', Announcement::class);
        $user = Auth::user();
        $levels = $this->getAllowedLevels($user);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'visibility_level' => 'required|in:' . implode(',', $levels),
            'entity_ids' => 'nullable|array',
            'entity_ids.*' => 'uuid',
        ]);

        $level = $data['visibility_level'];
        $entityIds = [];

        if ($level !== 'national') {
            $submitted = $request->input('entity_ids', []);

            if (!empty($submitted)) {
                $entityIds = $submitted;
            } else {
                // Auto-fill with user's own entity
                $auto = match ($level) {
                    'denomination' => $user->denomination_id,
                    'battalion'  => $user->battalion_id,
                    'company'    => $user->company_id,
                    default      => null,
                };
                if ($auto) {
                    $entityIds = [$auto];
                }
            }
        }

        $isApproved = $user->can('approve announcements');

        $announcement = Announcement::create([
            'title' => $data['title'],
            'content' => $data['content'],
            'visibility_level' => $level,
            'entity_ids' => !empty($entityIds) ? $entityIds : null,
            'entity_id' => $entityIds[0] ?? null,
            'created_by' => $user->id,
            'is_approved' => $isApproved,
            'approved_by' => $isApproved ? $user->id : null,
            'approved_at' => $isApproved ? now() : null,
        ]);

        // Send Notification (includes email if properly queued)
        $usersQuery = User::query()->where('is_approved', true);
        
        if ($level === 'national') {
            // notify everyone
        } elseif (!empty($entityIds)) {
            $usersQuery->where(function ($q) use ($level, $entityIds) {
                foreach ($entityIds as $id) {
                    $column = match ($level) {
                        'denomination' => 'denomination_id',
                        'battalion'  => 'battalion_id',
                        'company'    => 'company_id',
                        default      => null,
                    };
                    if ($column) {
                        $q->orWhere($column, $id);
                    }
                }
            });
        }

        Notification::send($usersQuery->get(), new NewAnnouncementNotification($announcement));

        return redirect()->route('announcements.index')->with('success', 'Announcement created successfully.');
    }

    /**
     * Display the specified announcement.
     */
    public function show(Announcement $announcement)
    {
        Gate::authorize('view', $announcement);
        $announcement->load('creator');
        return view('announcements.show', compact('announcement'));
    }

    /**
     * Show the form for editing the specified announcement.
     */
    public function edit(Announcement $announcement)
    {
        Gate::authorize('update', $announcement);
        $user = Auth::user();
        $levels = $this->getAllowedLevels($user);
        $denominations = Denomination::orderBy('name')->get();
        $battalions = Battalion::with('denomination')->orderBy('name')->get();
        $companies = Company::with('battalion')->orderBy('name')->get();

        return view('announcements.edit', compact('announcement', 'levels', 'denominations', 'battalions', 'companies'));
    }

    /**
     * Update the specified announcement.
     */
    public function update(Request $request, Announcement $announcement)
    {
        Gate::authorize('update', $announcement);
        $user = Auth::user();
        $levels = $this->getAllowedLevels($user);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'visibility_level' => 'required|in:' . implode(',', $levels),
            'entity_ids' => 'nullable|array',
            'entity_ids.*' => 'uuid',
        ]);

        $level = $data['visibility_level'];
        $entityIds = [];

        if ($level !== 'national') {
            $submitted = $request->input('entity_ids', []);

            if (!empty($submitted)) {
                $entityIds = $submitted;
            } else {
                $auto = match ($level) {
                    'denomination' => $user->denomination_id,
                    'battalion'  => $user->battalion_id,
                    'company'    => $user->company_id,
                    default      => null,
                };
                if ($auto) {
                    $entityIds = [$auto];
                }
            }
        }

        $announcement->update([
            'title' => $data['title'],
            'content' => $data['content'],
            'visibility_level' => $level,
            'entity_ids' => !empty($entityIds) ? $entityIds : null,
            'entity_id' => $entityIds[0] ?? null,
        ]);

        return redirect()->route('announcements.show', $announcement)->with('success', 'Announcement updated successfully.');
    }

    /**
     * Remove the specified announcement.
     */
    public function destroy(Announcement $announcement)
    {
        Gate::authorize('delete', $announcement);
        $announcement->delete();
        return redirect()->route('announcements.index')->with('success', 'Announcement deleted successfully.');
    }

    /**
     * Approve the specified announcement.
     */
    public function approve(Announcement $announcement)
    {
        Gate::authorize('approve', $announcement);

        $announcement->update([
            'is_approved' => true,
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);

        return redirect()->route('announcements.show', $announcement)
            ->with('success', 'Announcement approved successfully.');
    }

    /**
     * Determine which visibility levels the current user can create announcements for.
     */
    private function getAllowedLevels($user): array
    {
        if ($user->hasRole('Super Admin')) {
            return ['national', 'denomination', 'battalion', 'company'];
        } elseif ($user->hasRole('Denomination Admin')) {
            return ['denomination', 'battalion'];
        } elseif ($user->hasRole('Battalion Commander')) {
            return ['battalion', 'company'];
        } elseif ($user->hasRole('Company Captain')) {
            return ['company'];
        }
        return [];
    }
}
