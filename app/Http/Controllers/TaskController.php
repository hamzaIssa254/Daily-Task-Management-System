<?php

namespace App\Http\Controllers;

use App\Http\Requests\Tasks\StoreTaskRequest;
use App\Http\Requests\Tasks\UpdateTaskRequest;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\TaskService;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{

    protected $taskService;

    /**
     * Summary of __construct
     * @param \App\Services\TaskService $taskService
     */
    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }
    /**
     * Summary of index
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $status = $request->query('status');
        $tasks = $this->taskService->getTasks($status);

        return view('tasks.index', compact('tasks'));
    }


    /**
     * Summary of create
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('tasks.create');
    }
    /**
     * Summary of store
     * @param \App\Http\Requests\Tasks\StoreTaskRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreTaskRequest $request)
    {
        $data = $request->validated();

        $task = $this->taskService->createTask($data);

        if ($task) {
            return redirect()->route('tasks.index')->with('success', 'Task created successfully');
        } else {
            return back()->withErrors('Failed to create task');
        }
    }
    /**
     * Summary of edit
     * @param \App\Models\Task $task
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Task $task)
    {
        // $this->authorize('update', $task);

        return view('tasks.edit', compact('task'));
    }
    /**
     * Summary of update
     * @param \App\Http\Requests\Tasks\UpdateTaskRequest $request
     * @param \App\Models\Task $task
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        $data = $request->validated();

        $result = $this->taskService->updateTask($task, $data);

        if ($result) {
            return redirect()->route('tasks.index')->with('success', 'Task updated successfully');
        } else {
            return back()->withErrors('Failed to update task');
        }
    }
    /**
     * Summary of destroy
     * @param \App\Models\Task $task
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Task $task)
    {
        $result = $this->taskService->deleteTask($task);

        if ($result) {
            return redirect()->route('tasks.index')->with('success', 'Task deleted successfully');
        } else {
            return back()->withErrors('Failed to delete task');
        }
    }
}
