<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Task;
use App\DB\Tasks;

class TaskController extends Controller
{

    public function edit(Task $task, bool $editable=false)
    {
        $this->authorize('task.edit');

        return view('tasks.edit', ['task' => $task, 'editable'=>$editable]);
    }

}
