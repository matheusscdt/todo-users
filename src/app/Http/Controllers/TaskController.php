<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Requests\TaskRequest;
use Illuminate\Support\Facades\Auth;
use App\Services\TaskService;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Gate;

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
        if (!Auth::check()) {
            return response(redirect()->route('welcome')->with('error', 'You must be logged in to view tasks.'));
        }

        $tasks = Task::where('user_id', Auth::id())->get();

        return response()->json(['tasks' => $tasks]);
    }

    /**
     * Show the form for creating a new task.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('tasks.create');
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
        $data['user_id'] = Auth::id();

        Task::create($data);

        return redirect()->route('tasks.tasks');
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
     * Show the form for editing the specified task.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id): View
    {
        $task = Task::findOrFail($id);
        $this->authorize('update', $task);

        return view('tasks.edit', compact('task'));
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

        if (Gate::denies('update', $task)) {
            return response()->json(['error' => 'You are not authorized to update this task.'], 403);
        }

        $task->update($request->validated());

        return redirect()->route('tasks.tasks');
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

        $task->delete();
        return redirect()->route('tasks.tasks');
    }

    /**
     * Show the tasks view.
     *
     * @return \Illuminate\View\View
     */
    public function showTasks()
    {
        $tasks = Task::where('user_id', Auth::id())->get();
        return view('tasks.tasks', compact('tasks'));
    }
}
