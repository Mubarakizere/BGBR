<?php

namespace App\Http\Controllers;

use App\Models\MaterialsRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class MaterialsRequestController extends Controller
{
    public function index(Request $request)
    {
        Gate::authorize('viewAny', MaterialsRequest::class);

        $user = $request->user();

        // ── 1. Role-Based Scoping ──────────────────────────────
        $query = MaterialsRequest::query();

        if ($user->hasRole('Denomination Admin') && !$user->hasRole('Super Admin')) {
            $query->whereHas('company.battalion', function ($q) use ($user) {
                $q->where('denomination_id', $user->denomination_id);
            });
        } elseif ($user->hasRole('Battalion Commander') && !$user->hasRole('Super Admin')) {
            $query->whereHas('company', function ($q) use ($user) {
                $q->where('battalion_id', $user->battalion_id);
            });
        } elseif ($user->hasRole('Company Captain') && !$user->hasRole('Super Admin')) {
            $query->where('company_id', $user->company_id);
        }

        // ── 2. Calculate Aggregates (respecting role scopes) ──
        $statsQuery = clone $query;
        $totalCount    = $statsQuery->count();
        $pendingCount  = (clone $statsQuery)->where('status', 'pending')->count();
        $approvedCount = (clone $statsQuery)->whereIn('status', ['approved', 'fulfilled'])->count();
        $rejectedCount = (clone $statsQuery)->where('status', 'rejected')->count();

        // ── 3. Apply Server-Side Filters ───────────────────────
        if ($request->filled('search')) {
            $query->where('item_name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // ── 4. Retrieve Paginated Results ──────────────────────
        $requests = $query->with('company.battalion')
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('materials_requests.index', compact(
            'requests',
            'totalCount',
            'pendingCount',
            'approvedCount',
            'rejectedCount'
        ));
    }

    public function store(Request $request)
    {
        Gate::authorize('create', MaterialsRequest::class);
        
        $request->validate([
            'item_name' => 'required|string|max:255',
            'quantity'  => 'required|integer|min:1',
        ]);

        // Automatically assign company based on the captain's company
        $materialsRequest = MaterialsRequest::create([
            'company_id' => $request->user()->company_id,
            'item_name'  => $request->item_name,
            'quantity'   => $request->quantity,
            'status'     => 'pending',
        ]);

        $company = $materialsRequest->company;
        $commanders = \App\Models\User::role('Battalion Commander')->where('battalion_id', $company->battalion_id)->get();
        $superAdmins = \App\Models\User::role('Super Admin')->get();
        $notifiables = $commanders->merge($superAdmins);
        
        \Illuminate\Support\Facades\Notification::send($notifiables, new \App\Notifications\NewMaterialRequestNotification($materialsRequest));

        return back()->with('success', 'Materials request submitted successfully.');
    }

    public function update(Request $request, MaterialsRequest $materialsRequest)
    {
        Gate::authorize('update', $materialsRequest);
        
        $request->validate([
            'status' => 'required|in:pending,approved,rejected,fulfilled',
        ]);

        $materialsRequest->update([
            'status' => $request->status,
        ]);

        return back()->with('success', 'Materials request status updated successfully.');
    }

    public function destroy(MaterialsRequest $materialsRequest)
    {
        Gate::authorize('delete', $materialsRequest);
        $materialsRequest->delete();
        return back()->with('success', 'Materials request deleted successfully.');
    }
}
