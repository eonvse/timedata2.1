<?php

namespace App\Livewire\Tasks;

use Livewire\Component;
use Livewire\Attributes\Validate;

use App\DB\Tasks;
//use App\Models\Task;

class EditContent extends Component
{
    #[Validate('nullable|min:10')]
    public $content;

    public $taskId;
    public $editable;

    public function mount($content, $taskId)
    {
        $this->content = $content;
        $this->taskId = $taskId;
        $this->editable = false;
    }

    public function openContent()
    {
        $this->editable = true;
    }

    public function closeContent()
    {
        $this->editable = false;
        $this->content = Tasks::getFieldValue($this->taskId,'content');

    }

    public function saveContent()
    {
        $this->content = trim($this->content);
        $this->validate();
        Tasks::setFieldValue($this->taskId,'content',$this->content);

        $message = "Содержание задачи обновлено";
        session()->flash('flash.banner', $message);
        session()->flash('flash.bannerStyle', 'success');

        $this->redirectRoute('tasks.edit', ['task'=>Tasks::get($this->taskId)]);

    }

    public function render()
    {
        return view('livewire.tasks.edit-content');
    }
}
