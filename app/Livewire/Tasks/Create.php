<?php

namespace App\Livewire\Tasks;

use Livewire\Component;



class Create extends Component
{
    public $sidebar;
    
    public function mount()
    {
        $this->sidebar = false;
    }

    public function showSidebar()
    {
        $this->sidebar=true;
    }

    public function closeSidebar()
    {
        $this->sidebar=false;
    }


    public function render()
    {
        return view('livewire.tasks.create');
    }
}
