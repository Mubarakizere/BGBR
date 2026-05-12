<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        if ($user->hasRole('Super Admin')) {
            return view('dashboard.super-admin');
        } elseif ($user->hasRole('Domination Admin')) {
            return view('dashboard.domination-admin');
        } elseif ($user->hasRole('Battalion Commander')) {
            return view('dashboard.battalion-commander');
        } elseif ($user->hasRole('Company Captain')) {
            return view('dashboard.company-captain');
        } elseif ($user->hasRole('Company Officer')) {
            return view('dashboard.company-officer');
        } else {
            return view('dashboard.member');
        }
    }
}
