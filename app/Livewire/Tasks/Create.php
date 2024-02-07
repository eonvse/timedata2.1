<?php

namespace App\Livewire\Tasks;

use Livewire\Attributes\Validate;
use Livewire\Component;

use Illuminate\Support\Facades\Auth;

use App\Models\Task;
use App\Models\Color;


class Create extends Component
{
    public $sidebar;

    #[Validate('required|min:3')]
    public $name;

    public $autor_id;
    public $team_id;
    public $color_id;

    public $day;


    public $start, $end;


    public $content;


    public $isDone;


    public $dateDone;




    public function mount()
    {
        $this->sidebar = false;
        $this->autor_id = Auth::id();
        $this->color_id = 1;
        $this->team_id = $this->isDone = 0;
    }

    public function showSidebar()
    {
        $this->sidebar=true;
    }

    public function closeSidebar()
    {
        $this->sidebar=false;
        $this->reset(['name','color_id']);
    }

    public function save()
    {
        $this->authorize('manage tasks');

        $this->validate();

        Task::create(
            //$this->only(['name', 'autor_id','color_id'])
            $this->all()
        );

        $message = "Добавлена новая задача: " . $this->name;
        session()->flash('flash.banner', $message);
        session()->flash('flash.bannerStyle', 'success');

        return redirect('/tasks');
    }

    public function render()
    {
        return view('livewire.tasks.create',['colors'=>Color::orderBy('base')->get()->toArray()]);
    }
}
