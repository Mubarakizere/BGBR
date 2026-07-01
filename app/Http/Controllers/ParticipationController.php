<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Member;
use App\Models\Company;
use App\Models\Battalion;
use App\Models\AccountDeposit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class ParticipationController extends Controller
{
    /**
     * Register a member to an activity.
     * Eligibility check: member must have registration_fee_paid = true
     * AND member's company must be active (>= 20 members).
     */
    public function store(Request $request, Activity $activity)
    {
        Gate::authorize('registerParticipant', Activity::class);

        $request->validate([
            'member_id' => 'required|exists:members,id',
        ]);

        $member = Member::with('company')->findOrFail($request->member_id);

        // Check if company is active
        if ($member->company && !$member->company->is_active) {
            $memberCount = $member->company->members()->count();
            return back()->with('error', "Cannot register {$member->name}: their company \"{$member->company->name}\" is inactive ({$memberCount} members, requires 20).");
        }

        // Eligibility check: registration fee must be paid
        if (!$member->registration_fee_paid) {
            return back()->with('error', "Cannot register {$member->name}: registration fee has not been paid.");
        }

        // Check if already registered
        if ($activity->members()->where('member_id', $member->id)->exists()) {
            return back()->with('error', 'This member is already registered for this activity.');
        }

        $activity->members()->attach($member->id, [
            'id' => Str::uuid(),
            'fee_paid' => false,
            'payment_date' => null,
            'eligible' => true,
            'eligibility_notes' => null,
            'registered_by' => $request->user()->id,
        ]);

        return back()->with('success', "{$member->name} has been registered for this activity.");
    }

    /**
     * Bulk register multiple members to an activity.
     */
    public function bulkStore(Request $request, Activity $activity)
    {
        Gate::authorize('registerParticipant', Activity::class);

        $request->validate([
            'member_ids'   => 'required|array|min:1',
            'member_ids.*' => 'exists:members,id',
        ]);

        $members = Member::with('company')->whereIn('id', $request->member_ids)->get();
        $registered = 0;
        $skipped = [];

        foreach ($members as $member) {
            // Skip if already registered
            if ($activity->members()->where('member_id', $member->id)->exists()) {
                $skipped[] = "{$member->name} (already registered)";
                continue;
            }

            // Skip if company inactive
            if ($member->company && !$member->company->is_active) {
                $skipped[] = "{$member->name} (inactive company: {$member->company->name})";
                continue;
            }

            // Skip if registration fee not paid
            if (!$member->registration_fee_paid) {
                $skipped[] = "{$member->name} (registration fee not paid)";
                continue;
            }

            $activity->members()->attach($member->id, [
                'id' => Str::uuid(),
                'fee_paid' => false,
                'payment_date' => null,
                'eligible' => true,
                'eligibility_notes' => null,
                'registered_by' => $request->user()->id,
            ]);
            $registered++;
        }

        $message = "{$registered} member(s) registered successfully.";
        if (!empty($skipped)) {
            $message .= ' Skipped: ' . implode('; ', $skipped);
        }

        return back()->with($registered > 0 ? 'success' : 'error', $message);
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
     * Bulk mark multiple participants' fees as paid.
     */
    public function bulkMarkPaid(Request $request, Activity $activity)
    {
        Gate::authorize('markPayment', Activity::class);

        $request->validate([
            'member_ids'   => 'required|array|min:1',
            'member_ids.*' => 'exists:members,id',
        ]);

        $marked = 0;

        foreach ($request->member_ids as $memberId) {
            $pivot = $activity->members()->where('member_id', $memberId)->first();
            if (!$pivot || $pivot->pivot->fee_paid) {
                continue;
            }

            $member = Member::find($memberId);

            $activity->members()->updateExistingPivot($memberId, [
                'fee_paid' => true,
                'payment_date' => now()->toDateString(),
            ]);

            // Auto-create national account deposit
            if ($activity->participation_fee > 0 && $member) {
                AccountDeposit::create([
                    'amount' => $activity->participation_fee,
                    'level' => 'national',
                    'entity_id' => $activity->id,
                    'description' => "Activity fee: {$activity->title} — {$member->name}",
                ]);
            }

            $marked++;
        }

        return back()->with('success', "{$marked} payment(s) recorded successfully. National deposits created.");
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
