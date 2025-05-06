<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Requests\TaskRequest;
use Illuminate\Support\Facades\Auth;
use App\Services\TaskService;

/**
 * Class TaskController
 *
 * Handles operations related to tasks.
 */
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TaskController extends Controller
{
    use AuthorizesRequests;

    private $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    /**
     * Display a listing of the tasks for the logged-in user.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Task::where('user_id', Auth::id())->get();
        return response()->view('tasks.index', ['tasks' => $tasks]);
    }

    /**
     * Store a newly created task in storage.
     *
     * @param \App\Http\Requests\TaskRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(TaskRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::user()->id;

        $task = $this->taskService->createTask($data);
        return response()->json($task, 201);
    }

    /**
     * Display the specified task.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $task = Task::findOrFail($id);
        $this->authorize('view', $task);

        return response()->json($task);
    }

    /**
     * Update the specified task in storage.
     *
     * @param \App\Http\Requests\TaskRequest $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(TaskRequest $request, $id)
    {
        $task = Task::findOrFail($id);
        $task->update($request->validated());
        return response()->json($task);
    }

    /**
     * Remove the specified task from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $this->authorize('delete', $task);

        $this->taskService->deleteTask($task);
        return response()->json(['message' => 'Task deleted successfully']);
    }
}