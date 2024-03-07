<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage Users') }}
        </h2>
    </x-slot>
    <div class="py-3">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg p-1">
                    @can('user.create')
                    <div class="p-2">
                        <x-button.create wire:click="openCreate">{{ __('Add New User') }}</x-button.create>
                    </div>
                    @endcan
                    <x-table>
                        <x-slot name="header">
                            <x-table.head>ID</x-table.head>
                            <x-table.head
                                    sortable
                                    wire:click="sortBy('name')"
                                    :direction="$sortField === 'name' ? $sortDirection : null">
                                    {{ __('User Name') }}
                            </x-table.head>
                            <x-table.head>{{ __('Email') }}</x-table.head>
                            <x-table.head>{{ __('User Roles') }}</x-table.head>
                            <x-table.head>{{ __('Action') }}</x-table.head>
                            </tr>
                        </x-slot>
                        @forelse ($users as $user)
                        <x-table.row>
                            <x-table.cell scope="row">{{ $user->id }}</x-table.cell>
                            <x-table.cell>{{ $user->name }}</x-table.cell>
                            <x-table.cell>{{ $user->email }}</x-table.cell>
                            <x-table.cell>
                                @if (!empty($user->getRoleNames()))
                                @foreach ($user->getRoleNames() as $rolename)
                                    <x-marker.role :name="$rolename" />
                                @endforeach
                            @endif
                            </x-table.cell>
                            <x-table.cell>
                                <div class="flex items-center">
                                    @can('user.edit')
                                        <x-link.icon-edit wire:click="openEdit({{ $user->id }})" title="{{ __('Edit') }}"/>
                                    @endcan
                                    @can('user.delete')
                                        @if ($user->id != Auth::id())
                                        <x-button.icon-del wire:click="openDelete({{ $user->id }})" title="{{ __('Delete') }}" />
                                        @endif
                                    @endcan
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
        <x-slot name="title"><span class="grow">{{ empty($itemUser['id']) ? __('Add New User') : __('Edit User') }}</span><x-button.icon-cancel wire:click="closeCreate" class="text-gray-700 hover:text-white" /></x-slot>
        <x-slot name="content">
            <form wire:submit="save">
                <div class="p-2">
                    <x-input.label>{{ __('User Name') }}</x-input.label>
                    <x-input.text wire:model="itemUser.name" required />
                    @error('itemUser.name') <x-error class="col-span-2">{{ $message }}</x-error> @enderror
                </div>
                @if (empty($itemUser['id']))
                <div class="p-2">
                    <x-input.label>{{ __('User Email') }}</x-input.label>
                    <x-input.text wire:model="itemUser.email" required />
                    @error('itemUser.email') <x-error class="col-span-2">{{ $message }}</x-error> @enderror
                </div>
                <div class="p-2">
                    <x-input.label>{{ __('User Password') }}</x-input.label>
                    <x-input.text wire:model="itemUser.password" required />
                    @error('itemUser.password') <x-error class="col-span-2">{{ $message }}</x-error> @enderror
                </div>
                @endif
                <div class="p-2">
                    <x-input.label>{{ __('User Roles') }}</x-input.label>
                    <div class="flex flex-wrap items-center">
                        @foreach ($selectedRoles as $role)
                        <div class="m-1">
                            <x-marker.role :name="$role" />
                        </div>
                        @endforeach
                    </div>
                    <div class="">
                        <select multiple wire:model.live='itemUser.rolesId' style="height: 210px;" required>
                            <option value="">Выберите роль</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}" {{ in_array($role->id, $itemUser['rolesId'] ?? []) ? 'selected' : '' }}>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('itemUser.rolesId') <x-error class="col-span-2">{{ $message }}</x-error> @enderror
                    </div>
                </div>
                <x-button.create type="submit">{{ __('Save') }}</x-button.create>
                <x-button.secondary wire:click="closeCreate">{{ __('Cancel') }}</x-button.secondary>
            </form>

        </x-slot>
    </x-modal-wire.dialog>

    <x-modal-wire.dialog wire:model="showDelete" maxWidth="md" type="warn">
        <x-slot name="title">
            <span class="grow">{{ __('User delete') }}</span>
            <x-button.icon-cancel wire:click="closeDelete" class="text-gray-700 hover:text-white dark:hover:text-white" />
        </x-slot>
        <x-slot name="content">
            <div class="flex-col space-y-2">
                <x-input.label class="text-lg font-medium">Вы действительно хотите удалить запись?
                    <div class="text-black dark:text-white text-xl">
                        {{ $itemUser['name'] ?? '' }}
                    </div>
                </x-input.label>
                <div class="flex flex-wrap items-center">
                @foreach ($itemUser['rolesName'] as $roleName )
                 <div class="m-1"><x-marker.role :name="$roleName" /></div>
                @endforeach
                </div>
                <div class="text-red-600 dark:text-red-200 shadow p-1">{{ __('User Delete Message') }}</div>
                    <x-button.secondary wire:click="closeDelete">{{ __('Cancel') }}</x-button.secondary>
                    <x-button.danger wire:click="destroy({{ $itemUser['id'] }})">{{ __('Delete')}}</x-button.danger>
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
