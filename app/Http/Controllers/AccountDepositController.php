<?php

namespace App\Http\Controllers;

use App\Models\AccountDeposit;
use App\Models\Battalion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AccountDepositController extends Controller
{
    public function index(Request $request)
    {
        Gate::authorize('viewAny', AccountDeposit::class);

        $user = $request->user();

        // ── Build a role-scoped base query ──────────────────────
        $query = AccountDeposit::query();

        if ($user->hasRole('Denomination Admin') && !$user->hasRole('Super Admin')) {
            // Only show deposits linked to battalions within the user's denomination
            $battalionIds = Battalion::where('denomination_id', $user->denomination_id)->pluck('id');
            $query->where(function ($q) use ($battalionIds) {
                $q->where('level', 'battalion')->whereIn('entity_id', $battalionIds);
            });
        }

        // ── Server-side filters ─────────────────────────────────
        if ($request->filled('search')) {
            $query->where('description', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('level')) {
            $query->where('level', $request->level);
        }

        if ($request->filled('battalion_id')) {
            $query->where('level', 'battalion')->where('entity_id', $request->battalion_id);
        }

        // ── Financial stats (computed on the filtered + scoped query) ─
        $statsQuery = clone $query;
        $totalAmount     = (clone $statsQuery)->sum('amount');
        $nationalAmount  = (clone $statsQuery)->where('level', 'national')->sum('amount');
        $battalionAmount = (clone $statsQuery)->where('level', 'battalion')->sum('amount');
        $transactionCount = (clone $statsQuery)->count();

        // ── Paginated results ───────────────────────────────────
        $deposits = $query->latest()->paginate(15)->withQueryString();

        // ── Scoped battalion list (for the filter + the modal) ──
        if ($user->hasRole('Super Admin')) {
            $battalions = Battalion::orderBy('name')->get();
        } else {
            $battalions = Battalion::where('denomination_id', $user->denomination_id)->orderBy('name')->get();
        }

        return view('account_deposits.index', compact(
            'deposits',
            'battalions',
            'totalAmount',
            'nationalAmount',
            'battalionAmount',
            'transactionCount',
        ));
    }

    public function store(Request $request)
    {
        Gate::authorize('create', AccountDeposit::class);

        $user = $request->user();

        $request->validate([
            'amount'      => 'required|numeric|min:0',
            'level'       => 'required|in:battalion,national',
            'entity_id'   => 'required|uuid',
            'description' => 'nullable|string|max:255',
        ]);

        if (!$user->hasRole('Super Admin')) {
            if ($request->level !== 'battalion') {
                return back()->with('error', 'Unauthorized to record national-level deposits.');
            }

            $battalion = Battalion::find($request->entity_id);
            if (!$battalion || $battalion->denomination_id !== $user->denomination_id) {
                return back()->with('error', 'Unauthorized to record deposits for this battalion.');
            }
        }

        AccountDeposit::create([
            'amount'      => $request->amount,
            'level'       => $request->level,
            'entity_id'   => $request->entity_id,
            'description' => $request->description,
        ]);

        return back()->with('success', 'Account deposit recorded successfully.');
    }

    public function destroy(AccountDeposit $accountDeposit)
    {
        Gate::authorize('delete', $accountDeposit);
        $accountDeposit->delete();
        return back()->with('success', 'Account deposit deleted successfully.');
    }
}
