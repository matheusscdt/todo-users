<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Task;
use App\Models\User;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_task(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('auth_token')->plainTextToken;

        $response = $this->withHeader('Authorization', "Bearer $token")
                         ->postJson('/api/tasks', [
                             'title' => 'Test Task',
                             'description' => 'Task description',
                             'status' => 'pending',
                             'user_id' => $user->id,
                         ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('tasks', ['title' => 'Test Task']);
    }

    public function test_user_can_view_tasks(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('auth_token')->plainTextToken;

        Task::factory()->count(3)->create(['user_id' => $user->id]);

        $response = $this->withHeader('Authorization', "Bearer $token")
                         ->getJson('/api/tasks');

        $response->assertStatus(200);
        $response->assertJsonCount(3);
    }

    public function test_user_can_delete_task(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('auth_token')->plainTextToken;

        $task = Task::factory()->create(['user_id' => $user->id]);

        $response = $this->withHeader('Authorization', "Bearer $token")
                         ->deleteJson("/api/tasks/{$task->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }
}