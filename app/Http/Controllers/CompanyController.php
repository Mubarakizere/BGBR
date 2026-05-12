<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Battalion;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::with('battalion')->orderBy('name')->get();
        $battalions = Battalion::with('domination')->orderBy('name')->get();
        return view('companies.index', compact('companies', 'battalions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'battalion_id' => 'required|exists:battalions,id',
            'date_started' => 'nullable|date',
        ]);

        Company::create($request->all());

        return back()->with('success', 'Company created successfully.');
    }

    public function update(Request $request, Company $company)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'battalion_id' => 'required|exists:battalions,id',
            'date_started' => 'nullable|date',
        ]);

        $company->update($request->all());

        return back()->with('success', 'Company updated successfully.');
    }

    public function destroy(Company $company)
    {
        $company->delete();
        return back()->with('success', 'Company deleted successfully.');
    }
}
