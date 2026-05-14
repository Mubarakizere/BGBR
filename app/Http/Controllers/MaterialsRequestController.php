<?php

namespace App\Http\Controllers;

use App\Models\MaterialsRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class MaterialsRequestController extends Controller
{
    public function index()
    {
        Gate::authorize('viewAny', MaterialsRequest::class);
        $requests = MaterialsRequest::with('company')->latest()->get();
        return view('materials_requests.index', compact('requests'));
    }

    public function store(Request $request)
    {
        Gate::authorize('create', MaterialsRequest::class);
        $request->validate([
            'item_name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
        ]);

        // Automatically assign company based on the captain's company
        MaterialsRequest::create([
            'company_id' => $request->user()->company_id,
            'item_name' => $request->item_name,
            'quantity' => $request->quantity,
            'status' => 'pending',
        ]);

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

        return back()->with('success', 'Materials request updated successfully.');
    }

    public function destroy(MaterialsRequest $materialsRequest)
    {
        Gate::authorize('delete', $materialsRequest);
        $materialsRequest->delete();
        return back()->with('success', 'Materials request deleted successfully.');
    }
}
