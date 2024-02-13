<?php

namespace App\Livewire\Tasks;

use Livewire\Component;

use Illuminate\Support\Facades\Auth;

use App\Models\Task;

class Edit extends Component
{
    public $task;
    public $editable;
    public $data;

    public function mount(Task $task, bool $editable=false)
    {
        $this->task = $task;
        $this->editable = $editable;
        $this->data = array(
            'name'=>$task->name,
            'team_id'=>$task->team_id,
            'color_id'=>$task->color_id,
            'day'=>$task->day,
            'start'=>$task->start,
            'end'=>$task->end,
            'content'=>$task->content,
            'isDone'=>$task->isDone,
            'dateDone'=>$task->dateDone,
        );
    }

    public function render()
    {
        return view('livewire.tasks.edit');
    }
}
