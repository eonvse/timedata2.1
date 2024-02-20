<?php

namespace App\Livewire;

use Livewire\Component;

class SortableLink extends Component
{
    public $list;
    public $field;
    public $direction;

    public function mount($list,$field,$direction=null)
    {
        $this->list = $list;
        $this->field = $field;
        $this->direction = $direction;

    }

    public function sort()
    {
        $this->direction = $this->direction === 'asc' ? 'desc' : 'asc';
    }

    public function render()
    {
        return view('livewire.sortable-link');
    }
}
