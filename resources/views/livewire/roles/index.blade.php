<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage Roles') }}
        </h2>
    </x-slot>
    <div class="py-3">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg p-1">
                    @can('role.create')
                    <div class="p-2">
                        <x-button.create wire:click="openCreate">{{ __('Add New Role') }}</x-button.create>
                    </div>
                    @endcan
                    <x-table>
                        <x-slot name="header">
                            <x-table.head>ID</x-table.head>
                            <x-table.head
                                    sortable
                                    wire:click="sortBy('name')"
                                    :direction="$sortField === 'name' ? $sortDirection : null">
                                    {{ __('Role Name') }}
                            </x-table.head>
                            <x-table.head>{{ __('Role Permissions') }}</x-table.head>
                            <x-table.head>{{ __('Action') }}</x-table.head>
                            </tr>
                        </x-slot>
                        @forelse ($roles as $role)
                        <x-table.row>
                            <x-table.cell scope="row">{{ $role->id }}</x-table.cell>
                            <x-table.cell>{{ $role->name }}</x-table.cell>
                            <x-table.cell>
                                @if ($role->name=='Super Admin')
                                    <x-marker.permission>{{ __('All') }}</x-marker.permission>
                                @else
                                    @forelse ($role->permissions as $permission)
                                    <x-marker.permission :name="$permission->name">{{ $permission->name }}</x-marker.permission>
                                    @empty
                                    -
                                    @endforelse
                                @endif
                            </x-table.cell>
                            <x-table.cell>
                                <div class="flex items-center">
                                    @if ($role->name!='Super Admin')
                                        @can('role.edit')
                                            <x-link.icon-edit wire:click="openEdit({{ $role->id }})" title="{{ __('Edit') }}"/>
                                        @endcan
                                        @can('role.delete')
                                            @if ($role->name!=Auth::user()->hasRole($role->name))
                                                <x-button.icon-del wire:click="openDelete({{ $role->id }})" title="{{ __('Delete') }}" />
                                            @endif
                                        @endcan
                                    @endif
                                </div>
                            </x-table.cell>
                        </x-table.row>
                        @empty
                        <x-table.row>
                            <x-table.cell colspan="4">
                                <div class="text-center p-1">
                                    <strong>{{ __('No Role Found!') }}</strong>
                                </div>
                            </x-table.cell>
                        </x-table.row>
                        @endforelse
                    </x-table>
                </div>
            </div>
        </div>
    </div>

    <x-modal-wire.dialog wire:model="showEdit" maxWidth="md">
        <x-slot name="title"><span class="grow">{{ empty($itemRole['id']) ? __('Add New Role') : __('Edit Role') }}</span><x-button.icon-cancel wire:click="closeCreate" class="text-gray-700 hover:text-white" /></x-slot>
        <x-slot name="content">
            <form wire:submit="save">
                <div class="p-2">
                    <x-input.label>{{ __('Role Name') }}</x-input.label>
                    <x-input.text wire:model="itemRole.name" required />
                    @error('itemRole.name') <x-error class="col-span-2">{{ $message }}</x-error> @enderror
                </div>

               <div class="p-2">
                    <x-input.label>{{ __('Role Permissions') }}</x-input.label>
                    <div class="flex flex-wrap items-center">
                        @foreach ($selectedPermissions as $permission)
                        <div class="m-1">
                            <x-marker.permission :name="$permission">{{ $permission }}</x-marker.permission>
                        </div>
                        @endforeach
                    </div>
                    <div class="">
                        <select multiple wire:model.live='itemRole.permissionsId' style="height: 210px;" required>
                            <option value="">Выберите разрешение</option>
                            @foreach ($permissions as $permission)
                                <option value="{{ $permission->id }}" {{ in_array($permission->id, $itemRole['permissionsId'] ?? []) ? 'selected' : '' }}>
                                    {{ $permission->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('itemRole.permissionsId') <x-error class="col-span-2">{{ $message }}</x-error> @enderror
                    </div>
                </div>
                <x-button.create type="submit">{{ __('Save') }}</x-button.create>
                <x-button.secondary wire:click="closeCreate">{{ __('Cancel') }}</x-button.secondary>
            </form>

        </x-slot>
    </x-modal-wire.dialog>

    <x-modal-wire.dialog wire:model="showDelete" maxWidth="md" type="warn">
        <x-slot name="title">
            <span class="grow">{{ __('Role delete') }}</span>
            <x-button.icon-cancel wire:click="closeDelete" class="text-gray-700 hover:text-white dark:hover:text-white" />
        </x-slot>
        <x-slot name="content">
            <div class="flex-col space-y-2">
                <x-input.label class="text-lg font-medium">Вы действительно хотите удалить запись?
                    <div class="text-black dark:text-white text-xl">
                        {{ $itemRole['name'] ?? '' }}
                    </div>
                </x-input.label>
                <div class="flex flex-wrap items-center">
                @foreach ($itemRole['permissionsName'] as $permissionName )
                 <div class="m-1"><x-marker.permission :name="$permissionName">{{ $permissionName }}</x-marker.permission></div>
                @endforeach
                </div>
                <div class="text-red-600 dark:text-red-200 shadow p-1">{{ __('Role Delete Message') }}</div>
                    <x-button.secondary wire:click="closeDelete">{{ __('Cancel') }}</x-button.secondary>
                    <x-button.danger wire:click="destroy({{ $itemRole['id'] }})">{{ __('Delete')}}</x-button.danger>
                </div>
        </x-slot>
    </x-modal-wire.dialog>

    <x-spinner wire:loading wire:target="sortBy" />
    <x-spinner wire:loading wire:target="openCreate" />
    <x-spinner wire:loading wire:target="closeCreate" />
    <x-spinner wire:loading wire:target="openEdit" />
    <x-spinner wire:loading wire:target="save" />
    <x-spinner wire:loading wire:target="openDelete" />
    <x-spinner wire:loading wire:target="closeDelete" />
    <x-spinner wire:loading wire:target="destroy" />

</div>
