<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_users(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('auth_token')->plainTextToken;

        User::factory()->count(26)->create();

        $response = $this->withHeader('Authorization', "Bearer $token")
                         ->getJson('/api/users');

        $response->assertStatus(200);
        $response->assertJsonCount(27);
    }

    public function test_user_can_update_user(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('auth_token')->plainTextToken;

        $response = $this->withHeader('Authorization', "Bearer $token")
                         ->putJson("/api/users/{$user->id}", [
                             'name' => 'Updated Name',
                         ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('users', ['name' => 'Updated Name']);
    }
}