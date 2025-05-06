<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\UserRequest;

class UserRequestTest extends TestCase
{
    public function test_user_request_validation_passes(): void
    {
        $data = [
            'name' => 'Valid Name',
            'email' => 'valid@example.com',
            'password' => 'password123',
        ];

        $validator = Validator::make($data, (new UserRequest())->rules());

        $this->assertTrue($validator->passes());
    }

    public function test_user_request_validation_fails(): void
    {
        $data = [
            'email' => 'invalid-email',
            'password' => '',
        ];

        $validator = Validator::make($data, (new UserRequest())->rules());

        $this->assertFalse($validator->passes());
        $this->assertArrayHasKey('password', $validator->errors()->toArray());
    }
}