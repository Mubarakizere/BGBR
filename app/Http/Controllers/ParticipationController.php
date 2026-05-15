<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Member;
use App\Models\AccountDeposit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ParticipationController extends Controller
{
    /**
     * Register a member to an activity.
     * Eligibility check: member must have registration_fee_paid = true.
     */
    public function store(Request $request, Activity $activity)
    {
        Gate::authorize('registerParticipant', Activity::class);

        $request->validate([
            'member_id' => 'required|exists:members,id',
        ]);

        $member = Member::findOrFail($request->member_id);

        // Eligibility check: registration fee must be paid
        $eligible = $member->registration_fee_paid;
        $eligibilityNotes = $eligible ? null : 'Registration fee not paid.';

        // Check if already registered
        if ($activity->members()->where('member_id', $member->id)->exists()) {
            return back()->with('error', 'This member is already registered for this activity.');
        }

        // Block ineligible members
        if (!$eligible) {
            return back()->with('error', "Cannot register {$member->name}: registration fee has not been paid.");
        }

        $activity->members()->attach($member->id, [
            'id' => \Illuminate\Support\Str::uuid(),
            'fee_paid' => false,
            'payment_date' => null,
            'eligible' => $eligible,
            'eligibility_notes' => $eligibilityNotes,
            'registered_by' => $request->user()->id,
        ]);

        return back()->with('success', "{$member->name} has been registered for this activity.");
    }

    /**
     * Mark a participant's fee as paid and auto-create a national account deposit.
     */
    public function markPaid(Request $request, Activity $activity, Member $member)
    {
        Gate::authorize('markPayment', Activity::class);

        // Verify the member is registered
        $pivot = $activity->members()->where('member_id', $member->id)->first();
        if (!$pivot) {
            return back()->with('error', 'This member is not registered for this activity.');
        }

        if ($pivot->pivot->fee_paid) {
            return back()->with('error', 'This participation fee has already been marked as paid.');
        }

        // Mark as paid
        $activity->members()->updateExistingPivot($member->id, [
            'fee_paid' => true,
            'payment_date' => now()->toDateString(),
        ]);

        // Auto-create national account deposit
        if ($activity->participation_fee > 0) {
            AccountDeposit::create([
                'amount' => $activity->participation_fee,
                'level' => 'national',
                'entity_id' => $activity->id,
                'description' => "Activity fee: {$activity->title} — {$member->name}",
            ]);
        }

        return back()->with('success', "Payment recorded for {$member->name}. National deposit created.");
    }

    /**
     * Remove a participant from an activity.
     */
    public function remove(Activity $activity, Member $member)
    {
        Gate::authorize('registerParticipant', Activity::class);

        $activity->members()->detach($member->id);

        return back()->with('success', "{$member->name} has been removed from this activity.");
    }
}
