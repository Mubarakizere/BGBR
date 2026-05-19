<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SecurityHardeningTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Seed roles and permissions for Spatie permission package in tests
        Permission::create(['name' => 'manage system settings']);
        $adminRole = Role::create(['name' => 'Super Admin']);
        $adminRole->givePermissionTo('manage system settings');
    }

    /**
     * Verify that our custom SecurityHeaders middleware injects the requested browser shields globally.
     */
    public function test_security_headers_are_present_globally(): void
    {
        $response = $this->get('/');

        $response->assertHeader('X-Frame-Options', 'DENY');
        $response->assertHeader('X-Content-Type-Options', 'nosniff');
        $response->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->assertHeader('Content-Security-Policy');
        $response->assertHeader('Permissions-Policy');
    }

    /**
     * Verify that rate limiters are correctly applied to auth POST endpoints.
     */
    public function test_rate_limiting_middlewares_are_active(): void
    {
        $routes = Route::getRoutes();

        // Check login POST route
        $loginPostRoute = $routes->match(request()->create('/login', 'POST'));
        $this->assertContains('throttle:login', $loginPostRoute->gatherMiddleware());

        // Check register POST route
        $registerPostRoute = $routes->match(request()->create('/register', 'POST'));
        $this->assertContains('throttle:register', $registerPostRoute->gatherMiddleware());

        // Check forgot-password POST route
        $forgotPostRoute = $routes->match(request()->create('/forgot-password', 'POST'));
        $this->assertContains('throttle:password-reset', $forgotPostRoute->gatherMiddleware());
    }

    /**
     * Verify that Role & Permission management routes are protected and restricted to Super Admins.
     */
    public function test_role_management_is_restricted_to_super_admin(): void
    {
        // Unauthenticated -> Redirects to login
        $this->get('/admin/roles')
            ->assertRedirect('/login');

        // Authenticated but unauthorized (regular member / non-admin user)
        $member = User::factory()->create(['is_approved' => true]);
        $this->actingAs($member)
            ->get('/admin/roles')
            ->assertStatus(403);

        // Authenticated and authorized (Super Admin with manage system settings)
        $admin = User::factory()->create(['is_approved' => true]);
        $admin->assignRole('Super Admin');

        $this->actingAs($admin)
            ->get('/admin/roles')
            ->assertStatus(200);
    }
}
