<?php

namespace App\Services;

use App\Models\Task;
use Illuminate\Support\Facades\Log;

class TaskService
{
    /**
     * Mark a task as completed.
     *
     * @param Task $task
     * @return Task
     */
    public function markAsCompleted(Task $task): Task
    {
        $task->status = 'completed';
        $task->save();

        Log::info("Task marked as completed", ['task_id' => $task->id]);

        return $task;
    }
}