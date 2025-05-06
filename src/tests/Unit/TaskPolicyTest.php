<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Task;
use App\Models\User;
use App\Policies\TaskPolicy;

class TaskPolicyTest extends TestCase
{
    public function test_user_can_view_task(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id]);

        $policy = new TaskPolicy();

        $this->assertTrue($policy->view($user, $task));
    }

    public function test_user_cannot_view_other_users_task(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->create();

        $policy = new TaskPolicy();

        $this->assertFalse($policy->view($user, $task));
    }

    public function test_user_can_delete_own_task(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id]);

        $policy = new TaskPolicy();

        $this->assertTrue($policy->delete($user, $task));
    }
}