<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register(): void
    {
        $response = $this->postJson('/api/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('users', ['email' => 'test@example.com']);
    }

    public function test_user_can_login(): void
    {
        $user = User::factory()->create([
            'password' => bcrypt('password'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['token']);
    }

    public function test_user_can_logout(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('auth_token')->plainTextToken;

        $response = $this->withHeader('Authorization', "Bearer $token")
                         ->postJson('/api/logout');

        $response->assertStatus(200);
    }
}