<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\RegistrationFee;
use App\Models\Company;
use App\Models\Member;

class SampleMembersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $companyId = Company::first()?->id;

        // 1. User about to finish subscription (expires in 3 days)
        $user1 = User::updateOrCreate(
            ['email' => 'expiring@example.com'],
            [
                'name' => 'John Expiring',
                'password' => bcrypt('password'),
                'is_approved' => true,
                'fee_valid_until' => now()->addDays(3),
                'company_id' => $companyId,
            ]
        );
        Member::updateOrCreate(
            ['name' => $user1->name],
            [
                'rank' => 'Member',
                'company_id' => $user1->company_id,
                'registration_fee_paid' => true,
            ]
        );

        // 2. User whose subscription has finished (expired 5 days ago)
        $user2 = User::updateOrCreate(
            ['email' => 'expired@example.com'],
            [
                'name' => 'Jane Expired',
                'password' => bcrypt('password'),
                'is_approved' => true,
                'fee_valid_until' => now()->subDays(5),
                'company_id' => $companyId,
            ]
        );
        Member::updateOrCreate(
            ['name' => $user2->name],
            [
                'rank' => 'Member',
                'company_id' => $user2->company_id,
                'registration_fee_paid' => false,
            ]
        );

        // 3. User who has a pending fee approval
        $pendingUser = User::updateOrCreate(
            ['email' => 'pending@example.com'],
            [
                'name' => 'Alice Pending',
                'password' => bcrypt('password'),
                'is_approved' => true,
                'fee_valid_until' => null, // Not yet approved
                'company_id' => $companyId,
            ]
        );

        RegistrationFee::updateOrCreate(
            ['user_id' => $pendingUser->id, 'year' => now()->year],
            [
                'amount' => 5000,
                'receipt_path' => 'receipts/sample.pdf',
                'status' => 'pending',
            ]
        );
        Member::updateOrCreate(
            ['name' => $pendingUser->name],
            [
                'rank' => 'Member',
                'company_id' => $pendingUser->company_id,
                'registration_fee_paid' => false,
            ]
        );

        // 4. Active user (expires in 6 months)
        $user4 = User::updateOrCreate(
            ['email' => 'active@example.com'],
            [
                'name' => 'Bob Active',
                'password' => bcrypt('password'),
                'is_approved' => true,
                'fee_valid_until' => now()->addMonths(6),
                'company_id' => $companyId,
            ]
        );
        Member::updateOrCreate(
            ['name' => $user4->name],
            [
                'rank' => 'Member',
                'company_id' => $user4->company_id,
                'registration_fee_paid' => true,
            ]
        );
        
        $this->command->info('Sample members with different subscription statuses created successfully.');
        $this->command->info('Emails: expiring@example.com, expired@example.com, pending@example.com, active@example.com');
        $this->command->info('Password for all: password');
    }
}
