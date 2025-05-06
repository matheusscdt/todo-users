<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Policies\UserPolicy;

class UserPolicyTest extends TestCase
{
    public function test_user_can_view_own_profile(): void
    {
        $user = User::factory()->create();

        $policy = new UserPolicy();

        $this->assertTrue($policy->view($user, $user));
    }

    public function test_user_cannot_view_other_users_profile(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        $policy = new UserPolicy();

        $this->assertFalse($policy->view($user, $otherUser));
    }

    public function test_user_can_update_own_profile(): void
    {
        $user = User::factory()->create();

        $policy = new UserPolicy();

        $this->assertTrue($policy->update($user, $user));
    }
}