<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\TaskRequest;

class TaskRequestTest extends TestCase
{
    public function test_task_request_validation_passes(): void
    {
        $data = [
            'title' => 'Valid Title',
            'description' => 'Valid description',
            'status' => 'pending',
        ];

        $validator = Validator::make($data, (new TaskRequest())->rules());

        $this->assertTrue($validator->passes());
    }

    public function test_task_request_validation_fails(): void
    {
        $data = [
            'title' => '',
        ];

        $validator = Validator::make($data, (new TaskRequest())->rules());

        $this->assertFalse($validator->passes());
        $this->assertArrayHasKey('status', $validator->errors()->toArray());
    }
}