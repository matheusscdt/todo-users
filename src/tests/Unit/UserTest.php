<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_has_tasks_relationship()
    {
        $user = User::factory()->create();

        $this->assertEmpty($user->tasks);
    }

    public function test_user_has_name_attribute()
    {
        $user = User::factory()->create(['name' => 'Test User']);

        $this->assertEquals('Test User', $user->name);
    }
}