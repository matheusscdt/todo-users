<?php

namespace Tests\Integration;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Task;
use App\Models\User;
use App\Services\TaskService;

class TaskIntegrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_task_creation_via_service(): void
    {
        $user = User::factory()->create();
        $taskService = new TaskService();

        $taskData = [
            'title' => 'Integration Test Task',
            'description' => 'This is a test task created via service.',
            'user_id' => $user->id,
        ];

        $task = $taskService->createTask($taskData);

        $this->assertInstanceOf(Task::class, $task);
        $this->assertDatabaseHas('tasks', ['title' => 'Integration Test Task']);
    }

    public function test_task_deletion_via_service(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id]);
        $taskService = new TaskService();

        $result = $taskService->deleteTask($task);

        $this->assertTrue($result);
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }
}