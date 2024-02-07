<?php

namespace App\Livewire\Tasks;

use Livewire\Component;

use App\Models\Task;

class Delete extends Component
{
    public $modal;
    public $task;

    public function mount()
    {
        $this->modal = false;
    }

    public function render()
    {
        return view('livewire.tasks.delete');
    }
}
