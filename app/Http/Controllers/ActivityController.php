<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Denomination;
use App\Models\Battalion;
use App\Models\Company;
use App\Models\Member;
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
        } elseif ($user->hasRole('Denomination Admin') && $user->denomination_id) {
            $domId = $user->denomination_id;
            $query->where(function ($q) use ($domId) {
                $q->where('target_audience', 'national')
                  ->orWhere(function ($q2) use ($domId) {
                      // entity_ids JSON contains this denomination
                      $q2->where('target_audience', 'denomination')
                         ->where(function ($q3) use ($domId) {
                             $q3->whereJsonContains('entity_ids', $domId)
                                ->orWhere('entity_id', $domId); // legacy fallback
                         });
                  })
                  ->orWhere(function ($q2) use ($domId) {
                      $battalionIds = Battalion::where('denomination_id', $domId)->pluck('id')->toArray();
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
            $domId = $battalion?->denomination_id;
            $query->where(function ($q) use ($btnId, $domId) {
                $q->where('target_audience', 'national')
                  ->orWhere(function ($q2) use ($domId) {
                      if ($domId) {
                          $q2->where('target_audience', 'denomination')
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
            $domId    = $battalion?->denomination_id;
            $btnId    = $company?->battalion_id;
            $cmpId    = $user->company_id;

            $query->where(function ($q) use ($domId, $btnId, $cmpId) {
                $q->where('target_audience', 'national')
                  ->orWhere(function ($q2) use ($domId) {
                      if ($domId) {
                          $q2->where('target_audience', 'denomination')
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

        // Filter by target audience
        if ($request->filled('audience')) {
            $query->where('target_audience', $request->audience);
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
     * Only passes ACTIVE entities to the view.
     */
    public function create()
    {
        Gate::authorize('create', Activity::class);

        $denominations = Denomination::orderBy('name')->get();

        // Only active battalions (>= 5 companies)
        $battalions = Battalion::active()
            ->with('denomination')
            ->withCount('companies')
            ->orderBy('name')
            ->get();
        $inactiveBattalionCount = Battalion::inactive()->count();

        // Only active companies (>= 20 members)
        $companies = Company::active()
            ->with('battalion')
            ->withCount('members')
            ->orderBy('name')
            ->get();
        $inactiveCompanyCount = Company::inactive()->count();

        return view('activities.create', compact(
            'denominations', 'battalions', 'companies',
            'inactiveBattalionCount', 'inactiveCompanyCount'
        ));
    }

    /**
     * Store a newly created activity.
     * Validates that all submitted entity_ids are active.
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
            'target_audience'  => 'required|in:national,denomination,battalion,company',
            'entity_ids'       => 'nullable|array',
            'entity_ids.*'     => 'uuid',
        ]);

        $level     = $data['target_audience'];
        $entityIds = [];

        if ($level !== 'national') {
            $submitted = $request->input('entity_ids', []);

            if (!empty($submitted)) {
                // Validate that all submitted entities are active
                $validationErrors = $this->validateActiveEntities($level, $submitted);
                if (!empty($validationErrors)) {
                    return back()->withInput()->withErrors(['entity_ids' => $validationErrors[0]]);
                }
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

        Notification::send($usersQuery->get(), new NewActivityNotification($activity));

        return redirect()->route('activities.index')->with('success', 'Activity created successfully.');
    }

    /**
     * Display the specified activity with participants and company breakdown.
     */
    public function show(Activity $activity)
    {
        Gate::authorize('view', $activity);

        $activity->load(['members.company.battalion']);

        // Build company-level participation breakdown
        $companyBreakdown = $this->buildCompanyBreakdown($activity);

        // Get available members scoped to activity's target entities
        $availableMembers = $this->getAvailableMembersForActivity($activity);

        return view('activities.show', compact('activity', 'companyBreakdown', 'availableMembers'));
    }

    /**
     * Show the form for editing the specified activity.
     */
    public function edit(Activity $activity)
    {
        Gate::authorize('update', $activity);

        $denominations = Denomination::orderBy('name')->get();

        // Only active battalions
        $battalions = Battalion::active()
            ->with('denomination')
            ->withCount('companies')
            ->orderBy('name')
            ->get();
        $inactiveBattalionCount = Battalion::inactive()->count();

        // Only active companies
        $companies = Company::active()
            ->with('battalion')
            ->withCount('members')
            ->orderBy('name')
            ->get();
        $inactiveCompanyCount = Company::inactive()->count();

        // Check if current activity targets any now-inactive entities
        $inactiveTargetWarnings = $this->checkInactiveTargets($activity);

        return view('activities.edit', compact(
            'activity', 'denominations', 'battalions', 'companies',
            'inactiveBattalionCount', 'inactiveCompanyCount', 'inactiveTargetWarnings'
        ));
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
            'target_audience'  => 'required|in:national,denomination,battalion,company',
            'entity_ids'       => 'nullable|array',
            'entity_ids.*'     => 'uuid',
        ]);

        $level     = $data['target_audience'];
        $entityIds = [];

        if ($level !== 'national') {
            $submitted = $request->input('entity_ids', []);

            if (!empty($submitted)) {
                // Validate that all submitted entities are active
                $validationErrors = $this->validateActiveEntities($level, $submitted);
                if (!empty($validationErrors)) {
                    return back()->withInput()->withErrors(['entity_ids' => $validationErrors[0]]);
                }
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

    // =========================================================================
    // Private helpers
    // =========================================================================

    /**
     * Validate that all submitted entity_ids belong to active entities.
     * Returns array of error messages (empty = valid).
     */
    private function validateActiveEntities(string $level, array $entityIds): array
    {
        $errors = [];

        if ($level === 'battalion') {
            foreach ($entityIds as $id) {
                $battalion = Battalion::find($id);
                if ($battalion && !$battalion->is_active) {
                    $companyCount = $battalion->companies()->count();
                    $errors[] = "Battalion \"{$battalion->name}\" is inactive ({$companyCount} companies, needs 5). Remove it or add more companies first.";
                }
            }
        } elseif ($level === 'company') {
            foreach ($entityIds as $id) {
                $company = Company::find($id);
                if ($company && !$company->is_active) {
                    $memberCount = $company->members()->count();
                    $errors[] = "Company \"{$company->name}\" is inactive ({$memberCount} members, needs 20). Remove it or add more members first.";
                }
            }
        }

        return $errors;
    }

    /**
     * Build company-level participation breakdown for an activity.
     */
    private function buildCompanyBreakdown(Activity $activity): array
    {
        // Determine which companies are in scope for this activity
        $scopedCompanyIds = $this->getScopedCompanyIds($activity);

        if (empty($scopedCompanyIds)) {
            return [];
        }

        $companies = Company::whereIn('id', $scopedCompanyIds)
            ->with('battalion')
            ->withCount('members')
            ->orderBy('name')
            ->get();

        $breakdown = [];

        foreach ($companies as $company) {
            $registeredMembers = $activity->members->where('company_id', $company->id);
            $paidCount = $registeredMembers->where('pivot.fee_paid', true)->count();
            $registeredCount = $registeredMembers->count();
            $totalMembers = $company->members_count;

            $expectedFees = $registeredCount * (float) $activity->participation_fee;
            $collectedFees = $paidCount * (float) $activity->participation_fee;

            $breakdown[] = [
                'company'         => $company,
                'is_active'       => $company->is_active,
                'total_members'   => $totalMembers,
                'registered'      => $registeredCount,
                'paid'            => $paidCount,
                'unpaid'          => $registeredCount - $paidCount,
                'expected_fees'   => $expectedFees,
                'collected_fees'  => $collectedFees,
                'percentage'      => $expectedFees > 0 ? round(($collectedFees / $expectedFees) * 100) : 0,
            ];
        }

        return $breakdown;
    }

    /**
     * Get the IDs of companies within the activity's target scope.
     */
    private function getScopedCompanyIds(Activity $activity): array
    {
        $entityIds = $activity->entity_ids ?? ($activity->entity_id ? [$activity->entity_id] : []);

        return match ($activity->target_audience) {
            'national' => Company::pluck('id')->toArray(),
            'denomination' => Company::whereHas('battalion', function ($q) use ($entityIds) {
                $q->whereIn('denomination_id', $entityIds);
            })->pluck('id')->toArray(),
            'battalion' => Company::whereIn('battalion_id', $entityIds)->pluck('id')->toArray(),
            'company' => $entityIds,
            default => [],
        };
    }

    /**
     * Get available members for registration, scoped to the activity's target entities.
     * Excludes already-registered members and members from inactive companies.
     */
    private function getAvailableMembersForActivity(Activity $activity): \Illuminate\Support\Collection
    {
        $scopedCompanyIds = $this->getScopedCompanyIds($activity);

        if (empty($scopedCompanyIds)) {
            return collect();
        }

        // Only members from active companies within scope
        $activeCompanyIds = Company::whereIn('id', $scopedCompanyIds)
            ->active()
            ->pluck('id')
            ->toArray();

        $registeredMemberIds = $activity->members->pluck('id')->toArray();

        return Member::whereIn('company_id', $activeCompanyIds)
            ->whereNotIn('id', $registeredMemberIds)
            ->with('company')
            ->orderBy('name')
            ->get();
    }

    /**
     * Check if the activity currently targets entities that have become inactive.
     */
    private function checkInactiveTargets(Activity $activity): array
    {
        $warnings = [];
        $entityIds = $activity->entity_ids ?? ($activity->entity_id ? [$activity->entity_id] : []);

        if (empty($entityIds)) {
            return $warnings;
        }

        if ($activity->target_audience === 'battalion') {
            foreach ($entityIds as $id) {
                $battalion = Battalion::find($id);
                if ($battalion && !$battalion->is_active) {
                    $warnings[] = "Battalion \"{$battalion->name}\" is now inactive ({$battalion->companies()->count()} companies, needs 5).";
                }
            }
        } elseif ($activity->target_audience === 'company') {
            foreach ($entityIds as $id) {
                $company = Company::find($id);
                if ($company && !$company->is_active) {
                    $warnings[] = "Company \"{$company->name}\" is now inactive ({$company->members()->count()} members, needs 20).";
                }
            }
        }

        return $warnings;
    }
}
