<?php

namespace App\Livewire\Tasks;

use Livewire\Component;

use App\Models\Task;

class Delete extends Component
{
    public $type;
    public $modal;
    public $task;

    private $types = array(
                            'icon',
                            'button'
                        );

    public function mount(Task $task)
    {
        $this->modal = false;
        $this->type = $this->types[0];
        $this->task = $task;
    }

    public function showModal()
    {
        $this->modal = true;
    }

    public function closeModal()
    {
        $this->modal = false;
    }

    public function destroy()
    {
        $this->task->delete();
        $this->modal = false;

        $message = "Удалена задача: " . $this->task->name;
        session()->flash('flash.banner', $message);
        session()->flash('flash.bannerStyle', 'danger');

        $this->redirect('/tasks');
    }

    public function render()
    {
        switch($this->type)
        {
            case 'icon':
                return view('livewire.tasks.delete-icon');
                break;
        }

    }
}
