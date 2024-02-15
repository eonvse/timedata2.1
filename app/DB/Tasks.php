<?php

namespace App\DB;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;

use App\Models\Task;
use App\Models\Colors;


class Tasks
{
    const DEFAULT_PAGINATE = 15;

    public static function list($paginate=self::DEFAULT_PAGINATE, $sortField='created_at', $sortDirection='desc', $filter=null)
    {
        $tasks = Task::orderBy($sortField,$sortDirection)->paginate($paginate);

        return $tasks;

    }

}
