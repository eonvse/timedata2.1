<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Task;
use App\DB\Tasks;

class TaskController extends Controller
{
    const PER_PAGE=20; //записей на страницу

    public function index(Request $request)
    {
        $sortField = $request->sortField ?? 'created_at';
        $sortDirection = $request->sortDirection ?? 'desc';
        $tasks = Tasks::list(Self::PER_PAGE, $sortField,$sortDirection);

        return view('tasks.index', ['tasks'=>$tasks,'sortField'=>$sortField, 'sortDirection'=>$sortDirection]);
    }

    public function edit(Task $task, bool $editable=false)
    {
        $this->authorize('manage tasks');

        return view('tasks.edit', ['task' => $task, 'editable'=>$editable]);
    }

}
