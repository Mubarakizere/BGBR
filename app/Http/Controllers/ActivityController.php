<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Domination;
use App\Models\Battalion;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewActivityNotification;

class ActivityController extends Controller
{
    /**
     * Display a listing of activities scoped to the user's target audience.
     */
    public function index(Request $request)
    {
        Gate::authorize('viewAny', Activity::class);

        $user = Auth::user();
        $query = Activity::withCount('members');

        // Scope visibility by target audience
        if ($user->hasRole('Super Admin')) {
            // Sees everything
        } elseif ($user->hasRole('Domination Admin') && $user->domination_id) {
            $domId = $user->domination_id;
            $query->where(function ($q) use ($domId) {
                $q->where('target_audience', 'national')
                  ->orWhere(function ($q2) use ($domId) {
                      // entity_ids JSON contains this domination
                      $q2->where('target_audience', 'domination')
                         ->where(function ($q3) use ($domId) {
                             $q3->whereJsonContains('entity_ids', $domId)
                                ->orWhere('entity_id', $domId); // legacy fallback
                         });
                  })
                  ->orWhere(function ($q2) use ($domId) {
                      $battalionIds = Battalion::where('domination_id', $domId)->pluck('id')->toArray();
                      $q2->where('target_audience', 'battalion')
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
            $domId = $battalion?->domination_id;
            $query->where(function ($q) use ($btnId, $domId) {
                $q->where('target_audience', 'national')
                  ->orWhere(function ($q2) use ($domId) {
                      if ($domId) {
                          $q2->where('target_audience', 'domination')
                             ->where(function ($q3) use ($domId) {
                                 $q3->whereJsonContains('entity_ids', $domId)
                                    ->orWhere('entity_id', $domId);
                             });
                      }
                  })
                  ->orWhere(function ($q2) use ($btnId) {
                      $q2->where('target_audience', 'battalion')
                         ->where(function ($q3) use ($btnId) {
                             $q3->whereJsonContains('entity_ids', $btnId)
                                ->orWhere('entity_id', $btnId);
                         });
                  })
                  ->orWhere(function ($q2) use ($btnId) {
                      $companyIds = Company::where('battalion_id', $btnId)->pluck('id')->toArray();
                      $q2->where('target_audience', 'company')
                         ->where(function ($q3) use ($companyIds) {
                             foreach ($companyIds as $cid) {
                                 $q3->orWhereJsonContains('entity_ids', $cid);
                             }
                             $q3->orWhereIn('entity_id', $companyIds); // legacy
                         });
                  });
            });
        } elseif (($user->hasRole('Company Captain') || $user->hasRole('Company Officer') || $user->hasRole('Member')) && $user->company_id) {
            $company  = Company::find($user->company_id);
            $battalion = $company?->battalion;
            $domId    = $battalion?->domination_id;
            $btnId    = $company?->battalion_id;
            $cmpId    = $user->company_id;

            $query->where(function ($q) use ($domId, $btnId, $cmpId) {
                $q->where('target_audience', 'national')
                  ->orWhere(function ($q2) use ($domId) {
                      if ($domId) {
                          $q2->where('target_audience', 'domination')
                             ->where(function ($q3) use ($domId) {
                                 $q3->whereJsonContains('entity_ids', $domId)
                                    ->orWhere('entity_id', $domId);
                             });
                      }
                  })
                  ->orWhere(function ($q2) use ($btnId) {
                      if ($btnId) {
                          $q2->where('target_audience', 'battalion')
                             ->where(function ($q3) use ($btnId) {
                                 $q3->whereJsonContains('entity_ids', $btnId)
                                    ->orWhere('entity_id', $btnId);
                             });
                      }
                  })
                  ->orWhere(function ($q2) use ($cmpId) {
                      $q2->where('target_audience', 'company')
                         ->where(function ($q3) use ($cmpId) {
                             $q3->whereJsonContains('entity_ids', $cmpId)
                                ->orWhere('entity_id', $cmpId);
                         });
                  });
            });
        } else {
            $query->where('target_audience', 'national');
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search by title
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $activities = $query->latest('date')->paginate(12);

        return view('activities.index', compact('activities'));
    }

    /**
     * Show the form for creating a new activity.
     */
    public function create()
    {
        Gate::authorize('create', Activity::class);

        $dominations = Domination::orderBy('name')->get();
        $battalions  = Battalion::with('domination')->orderBy('name')->get();
        $companies   = Company::with('battalion')->orderBy('name')->get();

        return view('activities.create', compact('dominations', 'battalions', 'companies'));
    }

    /**
     * Store a newly created activity.
     */
    public function store(Request $request)
    {
        Gate::authorize('create', Activity::class);

        $user = Auth::user();

        $data = $request->validate([
            'title'            => 'required|string|max:255',
            'description'      => 'nullable|string',
            'participation_fee'=> 'required|numeric|min:0',
            'requirements'     => 'nullable|string',
            'date'             => 'required|date',
            'status'           => 'required|in:upcoming,ongoing,completed,cancelled',
            'location'         => 'nullable|string|max:255',
            'target_audience'  => 'required|in:national,domination,battalion,company',
            'entity_ids'       => 'nullable|array',
            'entity_ids.*'     => 'uuid',
        ]);

        $level     = $data['target_audience'];
        $entityIds = [];

        if ($level !== 'national') {
            $submitted = $request->input('entity_ids', []);

            if (!empty($submitted)) {
                $entityIds = $submitted;
            } else {
                // Auto-fill with user's own entity
                $auto = match ($level) {
                    'domination' => $user->domination_id,
                    'battalion'  => $user->battalion_id,
                    'company'    => $user->company_id,
                    default      => null,
                };
                if ($auto) {
                    $entityIds = [$auto];
                }
            }
        }

        $data['entity_ids'] = !empty($entityIds) ? $entityIds : null;
        $data['entity_id']  = $entityIds[0] ?? null; // keep legacy column in sync

        $activity = Activity::create($data);

        // Send Notification to targeted users (officers + members)
        $usersQuery = User::query()->where('is_approved', true);

        if ($level === 'national') {
            // notify everyone
        } elseif (!empty($entityIds)) {
            $usersQuery->where(function ($q) use ($level, $entityIds) {
                foreach ($entityIds as $id) {
                    $column = match ($level) {
                        'domination' => 'domination_id',
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

        Notification::send($usersQuery->get(), new NewActivityNotification($activity));

        return redirect()->route('activities.index')->with('success', 'Activity created successfully.');
    }

    /**
     * Display the specified activity with participants.
     */
    public function show(Activity $activity)
    {
        Gate::authorize('view', $activity);

        $activity->load(['members.company']);

        return view('activities.show', compact('activity'));
    }

    /**
     * Show the form for editing the specified activity.
     */
    public function edit(Activity $activity)
    {
        Gate::authorize('update', $activity);

        $dominations = Domination::orderBy('name')->get();
        $battalions  = Battalion::with('domination')->orderBy('name')->get();
        $companies   = Company::with('battalion')->orderBy('name')->get();

        return view('activities.edit', compact('activity', 'dominations', 'battalions', 'companies'));
    }

    /**
     * Update the specified activity.
     */
    public function update(Request $request, Activity $activity)
    {
        Gate::authorize('update', $activity);

        $user = Auth::user();

        $data = $request->validate([
            'title'            => 'required|string|max:255',
            'description'      => 'nullable|string',
            'participation_fee'=> 'required|numeric|min:0',
            'requirements'     => 'nullable|string',
            'date'             => 'required|date',
            'status'           => 'required|in:upcoming,ongoing,completed,cancelled',
            'location'         => 'nullable|string|max:255',
            'target_audience'  => 'required|in:national,domination,battalion,company',
            'entity_ids'       => 'nullable|array',
            'entity_ids.*'     => 'uuid',
        ]);

        $level     = $data['target_audience'];
        $entityIds = [];

        if ($level !== 'national') {
            $submitted = $request->input('entity_ids', []);

            if (!empty($submitted)) {
                $entityIds = $submitted;
            } else {
                $auto = match ($level) {
                    'domination' => $user->domination_id,
                    'battalion'  => $user->battalion_id,
                    'company'    => $user->company_id,
                    default      => null,
                };
                if ($auto) {
                    $entityIds = [$auto];
                }
            }
        }

        $data['entity_ids'] = !empty($entityIds) ? $entityIds : null;
        $data['entity_id']  = $entityIds[0] ?? null;

        $activity->update($data);

        return redirect()->route('activities.show', $activity)->with('success', 'Activity updated successfully.');
    }

    /**
     * Remove the specified activity.
     */
    public function destroy(Activity $activity)
    {
        Gate::authorize('delete', $activity);

        $activity->members()->detach();
        $activity->delete();

        return redirect()->route('activities.index')->with('success', 'Activity deleted successfully.');
    }
}
