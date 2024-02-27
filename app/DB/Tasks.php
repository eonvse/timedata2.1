<?php

namespace App\DB;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

use App\Models\Task;
use App\Models\Colors;


class Tasks
{

    public static function list($paginate, $sortField, $sortDirection, $filter=null)
    {
        $tasks = Task::orderBy($sortField,$sortDirection)->paginate($paginate);

        return $tasks;

    }

    public static function wire_list($sortField, $sortDirection, $filter=null)
    {
        $tasks = Task::orderBy($sortField,$sortDirection);

        return $tasks;

    }

    public static function get($id)
    {
        return Task::find($id);
    }

    public static function getFieldValue($id, $field)
    {
        return Task::where('id','=',$id)->pluck($field)->toArray()[0];
    }

    public static function setFieldValue($id, $field,$value) : void
    {
        Task::where('id','=',$id)->update([$field=>$value]);
    }

    public static function create($validated)
    {
        Task::create($validated);
    }

}
