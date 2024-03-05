<?php

namespace App\Livewire\Users;

use Livewire\Component;
use Livewire\Attributes\Title;

use App\Models\User;

use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\DB;
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
        $user = User::find($userId);

        $roleIds = DB::table("model_has_roles")->where("model_id",$user->id)
            ->pluck('role_id')
            ->all();

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

        $this->selectedRoles = DB::table("roles")->whereIn("id",$selected)
        ->pluck('name')
        ->all();

        //Log::debug('selectedPermissions = ' . implode(',',$this->selectedPermissions));


    }

    public function mount()
    {
        $this->resetUser();
        $this->showEdit = $this->showDelete = false;
        $this->sortField = 'name';
        $this->sortDirection = 'asc';
        $this->roles = DB::table('roles')->orderBy('name','asc')->get();
    }

    public function render()
    {
        $users = User::orderBy($this->sortField,$this->sortDirection)->get();
        return view('livewire.users.index',['users'=>$users]);
    }

    public function rules()
    {
        $rules = [];

        $rules['itemUser.name'] = 'required|string|min:3|max:255';
        $rules['itemUser.email'] = 'required|email|max:255|unique:users,email';
        $rules['itemUser.password'] = 'required|string|min:8|max:20';

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
        if($this->itemUser['id']==0) {

            $this->validate();

            $user = User::create([
                'name' => $this->itemUser['name'],
                'email' => $this->itemUser['email'],
                'password' => Hash::make($this->itemUser['password']),
            ]);

            /*foreach ($this->itemUser['rolesId'] as $select)
            {
                DB::table('model_has_roles')->insert([
                    'model_id'=>$user->id,
                    'model_type'=>'App\Models\User',
                    'role_id'=>$select,
                ]);
            }*/

            $user->syncRoles($this->selectedRoles);

            $message = "Добавлен пользователь: " . $this->itemUser['name'];

        }else{

            $role = Role::findById($this->itemUser['id']);
            $role->update(['name'=>$this->itemUser['name']]);

            $message = "Роль: " . $this->itemUser['name'] . " сохранена.";
        }

        //$permissions = Permission::whereIn('id', $this->itemRole['permissionsId'])->get(['name'])->toArray();
        //$role->syncPermissions($permissions);

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

    public function destroy($roleId)
    {

        $this->mountUser($roleId);

        if($this->itemRole['name']=='Super Admin'){
            abort(403, 'SUPER ADMIN ROLE CAN NOT BE DELETED');
        }
        /*if(Auth::user()->hasRole($this->itemRole['name'])){
            abort(403, 'CAN NOT DELETE SELF ASSIGNED ROLE');
        }*/
        DB::table("role_has_permissions")->where("role_id",$roleId)->delete();
        DB::table("roles")->where("id",$roleId)->delete();

        $message = "Роль: " . $this->itemRole['name'] . " удалена.";
        $this->dispatch('banner-message', style:'danger', message: $message);

        $this->closeDelete();
    }

}
