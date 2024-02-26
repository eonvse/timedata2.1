<?php

namespace App\Livewire;

use Livewire\Component;

class SortableLink extends Component
{
    public $text;
    public $list;
    public $field;
    public $sortField, $sortDirection;
    public $query;

    public function mount($text,$list,$field,$query)
    {
        $this->text = $text;
        $this->list = $list;
        $this->field = $field;
        $this->query = $query;
        $this->sortField = $query['sortField'] ?? 'created_at';
        $this->sortDirection = $query['sortDirection'] ?? 'desc';

    }

    public function sort()
    {
        $this->sortDirection = $this->sortField === $this->field
                            ? $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc'
                            : 'asc';

        $this->query['sortField'] = $this->field;
        $this->query['sortDirection'] = $this->sortDirection;

        $url = '/' . $this->list . '?' . http_build_query($this->query);

        $this->redirect($url);
    }

    public function render()
    {
        return view('livewire.sortable-link');
    }
}
