<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use App\DB\Tasks;

class TaskController extends Controller
{
    const PER_PAGE=20; //записей на страницу

    public function index()
    {
        $tasks = Tasks::list($paginate=Self::PER_PAGE);

        return view('tasks.index', compact('tasks'));
    }

    public function edit(Task $task, bool $editable=false)
    {
        $this->authorize('manage tasks');

        return view('tasks.edit', ['task' => $task, 'editable'=>$editable]);
    }

    public function update(UpdateTaskRequest $request, Task $task)
    {
        $this->authorize('manage tasks');

        $task->update($request->validated());

        return redirect()->route('tasks.index');
    }

}
