<?php

namespace App\Livewire\Users;

use Livewire\Component;
use Livewire\Attributes\Title;

use App\DB\Users;

use Illuminate\Support\Facades\Hash;
//use Illuminate\Support\Facades\Log;

#[Title('Пользователи')]
class Index extends Component
{
    public $itemUser;

    public $showEdit, $showDelete;

    public $sortField, $sortDirection; //сортировка по полю

    public $roles;

    public array $selectedRoles;

    public function resetUser()
    {
        $this->itemUser = array(
            'id'=>0,
            'name'=>'',
            'email'=>'',
            'password'=>null,
            'rolesId'=>array(
                'id'=>null,
            ),
            'rolesName'=>array(''),
        );

        $this->selectedRoles = array();

        $this->resetValidation();
    }

    public function mountUser($userId)
    {
        $user = Users::get($userId);

        $roleIds = Users::getRolesId($userId);

        $roleNames = $user->getRoleNames()->toArray();

        $this->itemUser = array(
            'id'=>$user->id,
            'name'=>$user->name,
            'email'=>$user->email,
            'password'=>$user->password,
            'rolesId'=>$roleIds,
            'rolesName'=>$roleNames,
            );

        $this->selectedRoles = $roleNames;

        }

    private function updateSelectedRole(array $selected)
    {

        //Log::notice('---UPDATE SELECTED Permission---');
        //Log::debug('selected = ' . implode(',',$selected));

        $this->selectedRoles = Users::getSelectedRolesName($selected);

        //Log::debug('selectedPermissions = ' . implode(',',$this->selectedPermissions));


    }

    public function mount()
    {
        $this->resetUser();
        $this->showEdit = $this->showDelete = false;
        $this->sortField = 'name';
        $this->sortDirection = 'asc';
        $this->roles = Users::getRolesList();
    }

    public function render()
    {
        $users = Users::list($this->sortField,$this->sortDirection);
        return view('livewire.users.index',['users'=>$users]);
    }

    public function rules()
    {
        $rules = [];

        $rules['itemUser.name'] = 'required|string|min:3|max:255';
        if (empty($this->itemUser['id'])){
            $rules['itemUser.email'] = 'required|email|max:255|unique:users,email';
            $rules['itemUser.password'] = 'required|string|min:8|max:20';
        }

        return $rules;
    }


    public function updated($property)
    {
        // $property: The name of the current property that was updated
        //Log::notice('---UPDATED---');
        //Log::debug('property = ' . $property);
        //Log::debug('Ids = ' . implode(',',$this->itemRole['permissionsId']));
        //Log::debug('selectedPermissions = ' . implode(',',$this->selectedPermissions));

        if (str_contains($property,'itemUser.rolesId')) {
            $this->updateSelectedRole($this->itemUser['rolesId']);
        }
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
        $this->resetUser();
        $this->showEdit = true;
    }

    public function closeCreate()
    {
        //Log::notice('---CLOSE CREATE---');
        //Log::debug('Before Close Edit Ids =' . implode(',',$this->itemRole['permissionsId']));
        $this->resetUser();
        $this->showEdit = false;
    }

    public function openEdit($userId)
    {
        $this->mountUser($userId);
        $this->showEdit = true;

        //Log::notice('---OPEN EDIT---');
        //Log::debug('itemRole Ids =' . implode(',',$this->itemRole['permissionsId']));
        //Log::debug('selectedPermissions = ' . implode(',',$this->selectedPermissions));
    }

    public function save()
    {
        $this->validate();

        if($this->itemUser['id']==0) {

            $data = array(
                'name' => $this->itemUser['name'],
                'email' => $this->itemUser['email'],
                'password' => Hash::make($this->itemUser['password']),
            );
            $user = Users::create($data);

            $message = "Добавлен пользователь: " . $this->itemUser['name'];

        }else{

            $data = array('name'=>$this->itemUser['name']);
            $user = Users::update($this->itemUser['id'],$data);

            $message = "Пользователь: " . $this->itemUser['name'] . " сохранен.";
        }

        $user->syncRoles($this->selectedRoles);

        $this->dispatch('banner-message', style:'success', message: $message);

        $this->closeCreate();

    }

    public function openDelete($userId)
    {
        $this->mountUser($userId);
        $this->showDelete = true;
    }

    public function closeDelete()
    {
        $this->resetUser();
        $this->showDelete = false;
    }

    public function destroy($userId)
    {

        Users::delete($userId);

        $message = "Пользователь: " . $this->itemUser['name'] . " удален.";

        $this->dispatch('banner-message', style:'danger', message: $message);

        $this->closeDelete();
    }

}
