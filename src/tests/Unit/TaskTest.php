<?php

namespace Tests\Unit;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_task_has_user_relationship()
    {
        $task = Task::factory()->create();

        $this->assertNotNull($task->user);
    }

    public function test_task_has_title_attribute()
    {
        $task = Task::factory()->create(['title' => 'Test Task']);

        $this->assertEquals('Test Task', $task->title);
    }
}