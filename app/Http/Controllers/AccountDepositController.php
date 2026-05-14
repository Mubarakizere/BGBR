<?php

namespace App\Http\Controllers;

use App\Models\AccountDeposit;
use App\Models\Battalion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AccountDepositController extends Controller
{
    public function index()
    {
        Gate::authorize('viewAny', AccountDeposit::class);
        $deposits = AccountDeposit::latest()->get();
        $battalions = Battalion::orderBy('name')->get();
        return view('account_deposits.index', compact('deposits', 'battalions'));
    }

    public function store(Request $request)
    {
        Gate::authorize('create', AccountDeposit::class);
        $request->validate([
            'amount' => 'required|numeric|min:0',
            'level' => 'required|in:battalion,national',
            'entity_id' => 'required|uuid',
            'description' => 'nullable|string|max:255',
        ]);

        AccountDeposit::create([
            'amount' => $request->amount,
            'level' => $request->level,
            'entity_id' => $request->entity_id,
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
