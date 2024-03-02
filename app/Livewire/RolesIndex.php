<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Title;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class RolesIndex extends Component
{
    public $itemRole;

    public $permissions;

    public $showEdit, $showDelete;

    public function resetRole()
    {
        $this->itemRole = array(
            'id'=>0,
            'name'=>'',
            'permissionsId'=>array(
                'id'=>null,
            ),
            'permissionsName'=>array(''),
        );
    }

    public function mountRole($roleId)
    {
        $role = Role::findById($roleId);
        if($role->name=='Super Admin'){
            abort(403, 'SUPER ADMIN ROLE CAN NOT BE EDITED');
        }

        $rolePermissions = DB::table("role_has_permissions")->where("role_id",$role->id)
            ->pluck('permission_id')
            ->all();

        $rolePermissionsName = DB::table("permissions")->whereIn("id",$rolePermissions)
            ->pluck('name')
            ->all();

            $this->itemRole = array(
                'id'=>$role->id,
                'name'=>$role->name,
                'permissionsId'=>$rolePermissions,
                'permissionsName'=>$rolePermissionsName,
            );
        }

    public function mount()
    {
        $this->resetRole();
        $this->showEdit = $this->showDelete = false;
        $this->permissions = Permission::orderBy('name','asc')->get();
    }

    #[Title('Роли')]
    public function render()
    {
        return view('livewire.roles-index',[
            'roles' => Role::orderBy('name','asc')->get(),
        ]);
    }

    public function openCreate()
    {
        $this->resetRole();
        $this->showEdit = true;
    }

    public function closeCreate()
    {
        $this->resetRole();
        $this->showEdit = false;
    }

    public function openEdit($roleId)
    {
        $this->mountRole($roleId);
        $this->showEdit = true;
    }

    public function save()
    {
        if($this->itemRole['id']==0) {

            $role = Role::create(['name' => $this->itemRole['name']]);
            $message = "Создана роль: " . $this->itemRole['name'];

        }else{

            $role = Role::findById($this->itemRole['id']);
            $role->update(['name'=>$this->itemRole['name']]);

            $message = "Роль: " . $this->itemRole['name'] . " сохранена.";
        }

        $permissions = Permission::whereIn('id', $this->itemRole['permissionsId'])->get(['name'])->toArray();
        $role->syncPermissions($permissions);

        $this->dispatch('banner-message', style:'success', message: $message);

        $this->closeCreate();

    }

    public function openDelete($roleId)
    {
        $this->mountRole($roleId);
        $this->showDelete = true;
    }

    public function closeDelete()
    {
        $this->resetRole();
        $this->showDelete = false;
    }

    public function destroy($roleId)
    {

        $this->mountRole($roleId);

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
