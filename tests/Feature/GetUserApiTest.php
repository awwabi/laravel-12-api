<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GetUserApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_cannot_access_users_without_token()
    {
        $this->getJson('/api/users')
             ->assertStatus(401)
             ->assertJson(['message' => 'Unauthorized. Provide a valid API token.']);
    }

    public function test_invalid_token_returns_unauthorized()
    {
        $this->getJson('/api/users', [
            'Authorization' => 'Bearer invalid-token',
            'Accept' => 'application/json'
        ])->assertStatus(401)
          ->assertJson(['message' => 'Unauthorized. Provide a valid API token.']);
    }

    public function test_can_access_users_with_valid_token()
    {
        $admin = User::factory()->create(['role' => 'admin', 'api_token' => 'token']);

        $this->getJson('/api/users?page=1', [
            'Authorization' => 'Bearer token',
            'Accept' => 'application/json'
        ])->assertStatus(200)
          ->assertJsonStructure(['page', 'users']);
    }

    public function test_orders_count_is_returned_correctly()
    {
        $admin = User::factory()->create(['role' => 'admin', 'api_token' => 'token']);
        $user = User::factory()->create();
        Order::factory()->count(3)->create(['user_id' => $user->id]);

        $this->getJson('/api/users?page=1', [
            'Authorization' => 'Bearer token',
            'Accept' => 'application/json'
        ])->assertStatus(200)
          ->assertJsonFragment(['orders_count' => 3]);
    }

    public function test_can_edit_flag_true_for_admin()
    {
        $admin = User::factory()->create(['name' => 'aaa', 'role' => 'admin', 'api_token' => 'token']);
        User::factory()->create(['name' => 'bbb']);

        $result = $this->getJson('/api/users?page=1&sortBy=name', [
            'Authorization' => 'Bearer ' . $admin->api_token,
            'Accept' => 'application/json'
        ])->assertStatus(200);

        $data = $result->json();
        $this->assertEquals(1, $data['page']);
        $this->assertCount(2, $data['users']);
        $this->assertEquals('aaa', $data['users'][0]['name']);
        $this->assertEquals('bbb', $data['users'][1]['name']);
        $this->assertTrue($data['users'][1]['can_edit']);
    }

    public function test_can_edit_flag_true_for_manager()
    {
        $manager = User::factory()->create(['name' => 'aaa', 'role' => 'manager', 'api_token' => 'token']);
        User::factory()->create(['name' => 'bbb', 'role' => 'user']);

        $result = $this->getJson('/api/users?page=1&sortBy=name', [
            'Authorization' => 'Bearer ' . $manager->api_token,
            'Accept' => 'application/json'
        ])->assertStatus(200);

        $data = $result->json();
        $this->assertEquals(1, $data['page']);
        $this->assertCount(2, $data['users']);
        $this->assertEquals('aaa', $data['users'][0]['name']);
        $this->assertEquals('bbb', $data['users'][1]['name']);
        $this->assertTrue($data['users'][1]['can_edit']);
    }

    public function test_can_edit_flag_false_for_user()
    {
        $user = User::factory()->create(['name' => 'aaa', 'role' => 'user', 'api_token' => 'token']);
        User::factory()->create(['name' => 'bbb', 'role' => 'user']);

        $result = $this->getJson('/api/users?page=1&sortBy=name', [
            'Authorization' => 'Bearer ' . $user->api_token,
            'Accept' => 'application/json'
        ])->assertStatus(200);

        $data = $result->json();
        $this->assertEquals(1, $data['page']);
        $this->assertCount(2, $data['users']);
        $this->assertEquals('aaa', $data['users'][0]['name']);
        $this->assertEquals('bbb', $data['users'][1]['name']);
        $this->assertFalse($data['users'][1]['can_edit']);
    }

    public function test_invalid_page_param_returns_error()
    {
        $admin = User::factory()->create(['role' => 'admin', 'api_token' => 'token']);

        $this->getJson('/api/users?page=invalid', [
            'Authorization' => 'Bearer token',
            'Accept' => 'application/json'
        ])->assertStatus(422);
    }

    public function test_empty_user_list_returns_valid_response()
    {
        $admin = User::factory()->create(['role' => 'admin', 'api_token' => 'token']);

        $this->getJson('/api/users?page=1', [
            'Authorization' => 'Bearer token',
            'Accept' => 'application/json'
        ])->assertStatus(200)
          ->assertJson(['page' => 1, 'users' => []]);
    }
}
