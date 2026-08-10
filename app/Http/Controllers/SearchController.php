<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Battalion;
use App\Models\Company;
use App\Models\Member;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('q');
        
        $battalions = [];
        $companies = [];
        $members = [];

        if (!empty($query)) {
            // TenantScope automatically filters results based on user role for these models!
            $battalions = Battalion::with('denomination')
                ->where('name', 'like', '%' . $query . '%')
                ->limit(20)
                ->get();
                
            $companies = Company::with(['battalion', 'officers'])
                ->where('name', 'like', '%' . $query . '%')
                ->limit(20)
                ->get();
                
            $members = Member::with('company')
                ->where(function($q) use ($query) {
                    $q->where('first_name', 'like', '%' . $query . '%')
                      ->orWhere('last_name', 'like', '%' . $query . '%');
                })
                ->limit(20)
                ->get();
        }

        if ($request->wantsJson() || $request->ajax()) {
            $results = [
                'battalions' => $battalions->map(function($b) {
                    return [
                        'id' => $b->id,
                        'title' => $b->name,
                        'subtitle' => $b->denomination->name ?? 'No Denomination',
                        'url' => route('battalions.show', $b)
                    ];
                }),
                'companies' => $companies->map(function($c) {
                    return [
                        'id' => $c->id,
                        'title' => $c->name,
                        'subtitle' => $c->battalion->name ?? 'Unknown Battalion',
                        'url' => route('companies.show', $c)
                    ];
                }),
                'members' => $members->map(function($m) {
                    return [
                        'id' => $m->id,
                        'title' => $m->first_name . ' ' . $m->last_name,
                        'subtitle' => ($m->company->name ?? 'Unknown Company') . ' • ' . $m->rank,
                        'url' => route('members.show', $m)
                    ];
                })
            ];
            return response()->json($results);
        }

        return view('search.index', compact('query', 'battalions', 'companies', 'members'));
    }
}
