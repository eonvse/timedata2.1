<?php

namespace App\Livewire;

use Livewire\Component;

class SortableLink extends Component
{
    public $text;
    public $list;
    public $field;
    public $sortField, $sortDirection;

    public function mount($text,$list,$field,$sortField,$sortDirection)
    {
        $this->text = $text;
        $this->list = $list;
        $this->field = $field;
        $this->sortField = $sortField;
        $this->sortDirection = $sortDirection;

    }

    public function sort()
    {
        $this->sortDirection = $this->sortField === $this->field
                            ? $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc'
                            : 'asc';

        $url = '/tasks?sortField='.$this->field.'&sortDirection='.$this->sortDirection;

        $this->redirect($url);
    }

    public function render()
    {
        return view('livewire.sortable-link');
    }
}
