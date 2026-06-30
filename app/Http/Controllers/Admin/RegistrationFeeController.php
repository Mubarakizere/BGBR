<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RegistrationFee;
use App\Models\AccountDeposit;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RegistrationFeeController extends Controller
{
    public function index(Request $request)
    {
        $query = RegistrationFee::with('user');
        
        $user = $request->user();
        if (!$user->hasRole('Super Admin')) {
            $query->whereHas('user', function ($q) use ($user) {
                if ($user->company_id) {
                    $q->where('company_id', $user->company_id);
                } elseif ($user->battalion_id) {
                    $q->where('battalion_id', $user->battalion_id);
                } elseif ($user->denomination_id) {
                    $q->where('denomination_id', $user->denomination_id);
                }
            });
        }
        
        $fees = $query->orderBy('created_at', 'desc')->paginate(20);
        
        return view('admin.fees.index', compact('fees'));
    }

    public function approve(Request $request, RegistrationFee $fee)
    {
        $fee->update([
            'status' => 'approved',
            'approved_by' => $request->user()->id,
            'approved_at' => now(),
        ]);
        
        $user = $fee->user;
        $user->update([
            'fee_valid_until' => now()->addYear(),
        ]);
        
        $level = 'national';
        $entityId = Str::uuid()->toString();

        if ($user->battalion_id) {
            $level = 'battalion';
            $entityId = $user->battalion_id;
        } elseif ($user->company && $user->company->battalion_id) {
            $level = 'battalion';
            $entityId = $user->company->battalion_id;
        }
        
        AccountDeposit::create([
            'amount' => $fee->amount,
            'level' => $level,
            'entity_id' => $entityId,
            'description' => "Yearly Registration Fee - {$user->name} ({$fee->year})",
        ]);
        
        return back()->with('success', 'Fee approved successfully.');
    }

    public function reject(Request $request, RegistrationFee $fee)
    {
        $fee->update([
            'status' => 'rejected',
        ]);
        
        return back()->with('success', 'Fee rejected.');
    }
}
