<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;

class TaskController extends Controller
{
    const PER_PAGE=20; //записей на страницу

    public function index()
    {
        $tasks = Task::orderBy('created_at','desc')->paginate(self::PER_PAGE);

        return view('tasks.index', compact('tasks'));
    }

    public function edit(Task $task)
    {
        $this->authorize('manage tasks');

        return view('tasks.edit', compact('task'));
    }

    public function update(UpdateTaskRequest $request, Task $task)
    {
        $this->authorize('manage tasks');

        $task->update($request->validated());

        return redirect()->route('tasks.index');
    }

    public function destroy(Task $task)
    {
        $this->authorize('manage tasks');

        $task->delete();

        return redirect()->route('tasks.index');
    }
}
