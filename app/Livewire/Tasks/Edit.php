<?php

namespace App\Livewire\Tasks;

use Livewire\Component;
// use Livewire\Attributes\Validate; ???? Правила на элемент массива ????

use Illuminate\Support\Facades\Auth;

use App\Models\Task;
use App\Models\Color;

class Edit extends Component
{
    public $task;
    public $editable;
    public $data;

    public function mount(Task $task, bool $editable=false)
    {
        $this->task = $task;
        $this->editable = $editable;
        $this->resetData();
    }

    public function resetData()
    {
        $this->data = array(
            'name'=>$this->task->name,
            'team_id'=>$this->task->team_id,
            'color_id'=>$this->task->color_id,
            'day'=>$this->task->day,
            'start'=>$this->task->start,
            'end'=>$this->task->end,
            'content'=>$this->task->content,
            'isDone'=>$this->task->isDone,
            'dateDone'=>$this->task->dateDone,
        );
    }

    public function openEdit()
    {
        $this->editable = true;
    }

    public function cancelEdit()
    {
        $this->resetData();
        $this->editable = false;
    }

    public function render()
    {
        return view('livewire.tasks.edit',['colors'=>Color::orderBy('base')->get()->toArray()]);
    }
}
