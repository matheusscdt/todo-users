<?php

namespace App\Services;

use App\Models\Task;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

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

    /**
     * Create a new task.
     *
     * @param array $validatedData
     * @return Task
     */
    public function createTask(array $validatedData): Task
    {
        return Task::create($validatedData);
    }

    /**
     * Delete a task.
     *
     * @param Task $task
     * @return bool
     */
    public function deleteTask(Task $task): bool
    {
        return $task->delete();
    }
}