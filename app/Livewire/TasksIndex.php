<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

use App\DB\Tasks;
use App\Models\Color;

class TasksIndex extends Component
{
    use WithPagination, WithoutUrlPagination;

    private const PAGINATE=10;

    private $autor_id;

    public $newRecord, $delRecord; //массивы для модальных окон создания и удаления
    public $sortField, $sortDirection; //сортировка по полю
    public $filter; //массив фильтра
    public $showCreate, $showDelete;

    public $colors;

    public function resetRecords()
    {
        $this->newRecord = array(
            'name'=>null,
            'autor_id'=>$this->autor_id,
            'team_id'=>0,
            'color_id'=>1,
            'day'=>null,
            'start'=>null,
            'end'=>null,
            'content'=>null,
            'isDone'=>0,
            'dateDone'=>null,
        );

        $this->delRecord = array(
            'id'=>null,
            'name'=>null,
            'content'=>null,
        );

    }

    public function mount()
    {
        $this->autor_id = Auth::id();

        $this->resetRecords();

        $this->sortField = 'created_at';
        $this->sortDirection = 'desc';
        $this->filter=null;

        $this->showCreate = $this->showDelete = false;
        $this->colors = Color::orderBy('base')->get()->toArray();

    }

    #[Title('Задачи')]
    public function render()
    {
        $list = Tasks::wire_list($this->sortField,$this->sortDirection,$this->filter)->paginate(self::PAGINATE);
        return view('livewire.tasks-index',['list'=>$list]);
    }

    public function sortBy($field)
    {
        $this->sortDirection = $this->sortField === $field
                            ? $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc'
                            : 'asc';

        $this->sortField = $field;
    }

    public function openCreate()
    {
        $this->showCreate = true;
    }

    public function closeCreate()
    {
        $this->resetRecords();
        $this->showCreate = false;
    }

    public function save()
    {

        $validated = Validator::make(
            //Data
            [
                'name'=>$this->newRecord['name'],
                'autor_id'=>$this->newRecord['autor_id'],
                'team_id'=>$this->newRecord['team_id'],
                'color_id'=>$this->newRecord['color_id'],
                'day'=>$this->newRecord['day'],
                'start'=>$this->newRecord['start'],
                'end'=>$this->newRecord['end'],
                'content'=>$this->newRecord['content'],
                'isDone'=>$this->newRecord['isDone'],
                'dateDone'=>$this->newRecord['dateDone']
            ],

            //Rules
            [
                'name'=>'required|min:3',
                'autor_id'=>'decimal:0',
                'team_id'=>'decimal:0',
                'color_id'=>'decimal:0',
                'day'=>'nullable|date',
                'start'=>'nullable',
                'end'=>'nullable',
                'content'=>'nullable|min:10',
                'isDone'=>'nullable',
                'dateDone'=>'nullable|date',
            ]

        )->validate();

        Tasks::create($validated);
        $this->closeCreate();

        /*$message = "Задача " . $this->data['name'] . " сохранена";
        session()->flash('flash.banner', $message);
        session()->flash('flash.bannerStyle', 'success');

        $this->redirectRoute('tasks.edit', ['task'=>$this->task]);*/

    }
}
