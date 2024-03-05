<?php

namespace App\Livewire\Tasks;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;

use Illuminate\Support\Facades\Auth;

use App\DB\Tasks;
use App\Models\Color;

class Index extends Component
{
    use WithPagination, WithoutUrlPagination;

    private const PAGINATE=10;

    public $autor_id;

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

        $this->delRecord = null;

        $this->resetValidation();

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

    public function rules()
    {
        $rules = [];

        $rules['newRecord.name'] = 'required|min:3';
        $rules['newRecord.autor_id'] = 'decimal:0';
        $rules['newRecord.team_id'] = 'decimal:0';
        $rules['newRecord.color_id'] = 'decimal:0';
        $rules['newRecord.day'] = 'nullable|date';
        $rules['newRecord.start'] = 'nullable';
        $rules['newRecord.end'] = 'nullable';
        $rules['newRecord.content'] = 'nullable|min:10';
        $rules['newRecord.isDone'] = 'nullable';
        $rules['newRecord.dateDone'] = 'nullable|date';


        return $rules;
    }

    #[Title('Задачи')]
    public function render()
    {
        $list = Tasks::wire_list($this->sortField,$this->sortDirection,$this->filter)->paginate(self::PAGINATE);
        return view('livewire.tasks.index',['list'=>$list]);
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

        $this->validate();

        Tasks::create($this->newRecord);
        $message = "Задача " . $this->newRecord['name'] . " сохранена";
        $this->closeCreate();
        $this->dispatch('banner-message', style:'success', message: $message);

    }

    public function openDelete($task_id)
    {
        $this->delRecord = Tasks::getDelMessage($task_id);
        $this->showDelete = true;
    }

    public function closeDelete()
    {
        $this->delRecord = null;
        $this->showDelete = false;
    }

    public function destroy($task_id)
    {
        $message = "Удалена задача: " . Tasks::getFieldValue($task_id,'name');
        Tasks::delete($task_id);
        $this->closeDelete();
        $this->dispatch('banner-message', style:'danger', message: $message);
    }
}
