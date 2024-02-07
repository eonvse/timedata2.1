<?php

namespace App\Livewire\Tasks;

use Livewire\Component;

use App\Models\Task;

class Delete extends Component
{
    public $type;
    public $modal;
    public $task;

    private $types = array(     'icon',
                                'button'
                            );

    public function mount()
    {
        $this->modal = false;
        $this->type = $this->types[0];
    }

    public function render()
    {
        //return view('livewire.tasks.delete-icon',['debug'=>var_export($this->types)]);
        switch($this->type)
        {
            case 'icon':
                return view('livewire.tasks.delete-icon');
                break;
        }

    }
}
