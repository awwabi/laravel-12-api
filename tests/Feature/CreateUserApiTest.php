<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserCreatedMail;
use App\Mail\AdminNewUserNotificationMail;

class CreateUserApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_is_notified_when_new_user_created()
    {
        Mail::fake();

        $admin = User::factory()->create(['role' => 'admin', 'api_token' => 'token']);

        $this->postJson('/api/users', [
            'email' => 'test@example.com',
            'password' => 'secret password',
            'name' => 'Test User'
        ], ['Authorization' => 'Bearer token', 'Accept' => 'application/json'])
        ->assertStatus(201);

        Mail::assertSent(UserCreatedMail::class);
        Mail::assertSent(AdminNewUserNotificationMail::class);
    }

    public function test_create_user_requires_fields()
    {
        $admin = User::factory()->create(['role' => 'admin', 'api_token' => 'token']);

        $this->postJson('/api/users', [], ['Authorization' => 'Bearer token', 'Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['email', 'password', 'name']);
    }

    public function test_orders_count_is_returned_for_users()
    {
        $admin = User::factory()->create(['role' => 'admin', 'api_token' => 'token']);
        $user = User::factory()->create();
        Order::factory()->count(5)->create(['user_id' => $user->id]);

        $response = $this->getJson('/api/users?page=1', ['Authorization' => 'Bearer token', 'Accept' => 'application/json']);
        $response->assertStatus(200)->assertJsonFragment(['orders_count' => 5]);
    }

    public function test_can_edit_flag_is_set_correctly_for_admin()
    {
        $admin = User::factory()->create(['role' => 'admin', 'api_token' => 'token']);
        User::factory()->create();

        $this->getJson('/api/users?page=1', ['Authorization' => 'Bearer token', 'Accept' => 'application/json'])
             ->assertStatus(200)
             ->assertJsonFragment(['can_edit' => true]);
    }

    public function test_can_edit_flag_is_false_for_non_admin()
    {
        $manager = User::factory()->create(['role' => 'manager', 'api_token' => 'token']);
        User::factory()->create();

        $this->getJson('/api/users?page=1', ['Authorization' => 'Bearer token', 'Accept' => 'application/json'])
             ->assertStatus(200)
             ->assertJsonFragment(['can_edit' => false]);
    }

    public function test_invalid_token_returns_unauthorized()
    {
        $this->getJson('/api/users?page=1', ['Authorization' => 'Bearer invalid-token', 'Accept' => 'application/json'])
             ->assertStatus(401)
             ->assertJson(['message' => 'Unauthorized. Provide a valid API token.']);
    }

    public function test_cannot_create_user_with_existing_email()
    {
        $admin = User::factory()->create(['role' => 'admin', 'api_token' => 'token']);
        User::factory()->create(['email' => 'duplicate@example.com']);

        $this->postJson('/api/users', [
            'email' => 'duplicate@example.com',
            'password' => 'secret',
            'name' => 'Test User'
        ], ['Authorization' => 'Bearer token', 'Accept' => 'application/json'])
        ->assertStatus(422)
        ->assertJsonValidationErrors(['email']);
    }

    public function test_inactive_admin_cannot_create_user()
    {
        $admin = User::factory()->create(['role' => 'admin', 'api_token' => 'token', 'active' => false]);

        $this->postJson('/api/users', [
            'email' => 'inactive@example.com',
            'password' => 'secret password',
            'name' => 'Inactive User'
        ], ['Authorization' => 'Bearer token', 'Accept' => 'application/json'])
        ->assertStatus(403);
    }
}
