<?php

namespace App\Livewire\Tasks;

use Livewire\Component;
// use Livewire\Attributes\Validate; ???? Правила на элемент массива ????

//use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\Models\Task;
use App\Models\Color;
use App\DB\Tasks;

class Edit extends Component
{
    public $task;
    public $editable;
    public $data;
    public $delete;

    public function mount(Task $task, bool $editable=false)
    {
        $this->task = $task;
        $this->editable = $editable;
        $this->delete = false;
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

    public function clearField($field)
    {
        $this->data[$field]='';
    }

    public function store()
    {

        $validated = Validator::make(
            //Data
            [
                'name'=>$this->data['name'],
                'team_id'=>$this->data['team_id'],
                'color_id'=>$this->data['color_id'],
                'day'=>$this->data['day'],
                'start'=>$this->data['start'],
                'end'=>$this->data['end'],
                'content'=>$this->data['content'],
                'isDone'=>$this->data['isDone'],
                'dateDone'=>$this->data['dateDone']
            ],

            //Rules
            [
                'name'=>'required|min:3',
                'team_id'=>'decimal:0',
                'color_id'=>'decimal:0',
                'day'=>'nullable|date',
                'start'=>'nullable',
                'end'=>'nullable',
                'content'=>'nullable',
                'isDone'=>'nullable',
                'dateDone'=>'nullable|date',
            ]

        )->validate();

        $this->task->update($validated);

        $message = "Задача " . $this->data['name'] . " сохранена";
        session()->flash('flash.banner', $message);
        session()->flash('flash.bannerStyle', 'success');

        $this->redirectRoute('tasks.edit', ['task'=>$this->task]);

    }

    public function showDelete()
    {
        $this->delete = true;
    }

    public function closeDelete()
    {
        $this->delete = false;
    }

    public function destroy()
    {
        $this->task->delete();
        $this->delete = false;

        $message = "Удалена задача: " . $this->task->name;
        session()->flash('flash.banner', $message);
        session()->flash('flash.bannerStyle', 'danger');

        $this->redirect('/tasks');
    }


    public function render()
    {
        return view('livewire.tasks.edit',['colors'=>Color::orderBy('base')->get()->toArray()]);
    }
}
