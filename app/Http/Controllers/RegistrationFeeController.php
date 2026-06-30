<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RegistrationFeeController extends Controller
{
    public function create(Request $request)
    {
        $user = $request->user();
        
        // Check if there is an existing pending fee
        $pendingFee = $user->registrationFees()->where('status', 'pending')->first();
        
        return view('fees.pay', compact('pendingFee'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
            'receipt' => 'required|file|mimes:pdf,jpg,jpeg,png|max:102400', // Max 100MB
        ]);

        $path = $request->file('receipt')->store('receipts', 'public');

        $request->user()->registrationFees()->create([
            'amount' => $request->amount,
            'year' => now()->year,
            'receipt_path' => $path,
            'status' => 'pending',
        ]);

        return redirect()->route('fee.pay')->with('success', 'Fee payment proof submitted successfully and is pending approval.');
    }
}
