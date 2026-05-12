<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Domination;
use App\Models\Battalion;
use App\Models\Company;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SampleUsersSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure some basic hierarchy exists to link users
        $domination = Domination::firstOrCreate(['name' => 'Kigali City Domination', 'region' => 'Kigali']);
        $battalion = Battalion::firstOrCreate(['name' => '1st Kigali Battalion', 'domination_id' => $domination->id]);
        $company = Company::firstOrCreate(['name' => '1st Company Remera', 'battalion_id' => $battalion->id, 'date_started' => '2010-01-01']);

        $password = Hash::make('password');

        // Domination Admin
        $domAdmin = User::firstOrCreate(
            ['email' => 'domination@bgbr.rw'],
            ['name' => 'Domination Admin', 'password' => $password, 'is_approved' => true, 'domination_id' => $domination->id]
        );
        if (!$domAdmin->hasRole('Domination Admin')) $domAdmin->assignRole('Domination Admin');

        // Battalion Commander
        $btnCmdr = User::firstOrCreate(
            ['email' => 'battalion@bgbr.rw'],
            ['name' => 'Battalion Commander', 'password' => $password, 'is_approved' => true, 'battalion_id' => $battalion->id]
        );
        if (!$btnCmdr->hasRole('Battalion Commander')) $btnCmdr->assignRole('Battalion Commander');

        // Company Captain
        $captain = User::firstOrCreate(
            ['email' => 'captain@bgbr.rw'],
            ['name' => 'Company Captain', 'password' => $password, 'is_approved' => true, 'company_id' => $company->id]
        );
        if (!$captain->hasRole('Company Captain')) $captain->assignRole('Company Captain');

        // Company Officer
        $officer = User::firstOrCreate(
            ['email' => 'officer@bgbr.rw'],
            ['name' => 'Company Officer', 'password' => $password, 'is_approved' => true, 'company_id' => $company->id]
        );
        if (!$officer->hasRole('Company Officer')) $officer->assignRole('Company Officer');

        // Member
        $member = User::firstOrCreate(
            ['email' => 'member@bgbr.rw'],
            ['name' => 'Regular Member', 'password' => $password, 'is_approved' => true, 'company_id' => $company->id]
        );
        if (!$member->hasRole('Member')) $member->assignRole('Member');
    }
}
