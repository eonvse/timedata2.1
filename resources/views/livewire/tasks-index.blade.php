<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tasks list') }}
        </h2>
    </x-slot>
    <div class="py-3">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg p-1">
                    @can('manage tasks')
                    <div class="p-2">
                        <x-button.create wire:click="openCreate">{{ __('Add New Task') }}</x-button.create>
                    </div>
                    @endcan
                    <x-table>
                        <x-slot name="header">
                            <x-table.head>
                                {{ __('Task name') }}
                            </x-table.head>
                            <x-table.head scope="col"
                                        sortable
                                        wire:click="sortBy('day')"
                                        :direction="$sortField === 'day' ? $sortDirection : null">
                                        {{ __('Event Day') }}
                            </x-table.head>
                            <x-table.head class="text-center">{{ __('Task time') }}</x-table.head>
                            <x-table.head scope="col"
                                        sortable
                                        wire:click="sortBy('created_at')"
                                        :direction="$sortField === 'created_at' ? $sortDirection : null">
                                        {{ __('Created_at') }}
                            </x-table.head>
                            <x-table.head>{{ __('Autor') }}</x-table.head>
                            @can('manage tasks')
                            <x-table.head>

                            </x-table.head>
                            @endcan
                        </x-slot>
                        @forelse ($list as $task)
                            <x-table.row wire:key="{{ $task->id }}">
                                <x-table.cell>
                                    <div class="flex items-center">
                                        <div class="w-4 mx-1 {{ $task->color->base ?? '' }} dark:{{ $task->color->dark ?? '' }}">&nbsp;</div>
                                        <div><x-link.table-cell href="{{ route('tasks.edit', $task) }}" title="{{ __('Edit') }}">{{ $task->name }}</x-link.table-cell></div>
                                    </div>
                                </x-table.cell>
                                <x-table.cell class="tabular-nums">{{ $task->day_format }}</x-table.cell>
                                <x-table.cell class="tabular-nums text-center">
                                    <div class="grid grid-cols-2">
                                        <div>{{ $task->start_format }}</div>
                                        <div>{{ $task->end_format }}</div>
                                    </div>
                                </x-table.cell>
                                <x-table.cell class="tabular-nums">{{ $task->created }}</x-table.cell>
                                <x-table.cell>{{ $task->autor->name }}</x-table.cell>
                                @can('manage tasks')
                                <x-table.cell>
                                    <div class="flex items-center">
                                    <x-link.icon-edit href="{{ route('tasks.edit', ['task'=>$task, 'editable'=>1]) }}" title="{{ __('Edit') }}" />
                                    <x-link.icon-del  />
                                    </div>

                                </x-table.cell>
                                @endcan
                            </x-table.row>
                        @empty
                            <x-table.row>
                                <x-table.cell class="text-center" colspan="2">
                                    {{ __('No tasks found') }}
                                </x-table.cell>
                            </x-table.row>
                        @endforelse
                    </x-table>
                    <div class="m-2">{{ $list->links() }}</div>
                </div>
            </div>
        </div>
    </div>

    <x-sidebar wire:model="showCreate">
        <div class="w-full p-5 text-center shadow font-semibold text-xl">
            {{ __('Add New Task') }}
        </div>
        <div class="p-10 flex-col space-y-2">
            <div>

                <form wire:submit="save">
                    <input type="hidden" wire:model="newRecord.team_id" />
                    <div>
                        <x-input.label value="{{ __('Task name') }}" />
                        <x-input.text wire:model="newRecord.name" required autofocus />
                        @error('name') <x-error>{{ $message }}</x-error> @enderror
                    </div>
                    <div>
                        @php
                        $colorBg = '';
                        foreach ($colors as $color)
                            if ($color['id']==$newRecord['color_id']) $colorBg = $color['base'].' dark:'.$color['dark'];
                        @endphp
                        <x-input.label class="flex items-center">
                            Цвет
                            <div class="{{ $colorBg }} w-full m-2">&nbsp;</div>
                        </x-input.label>
                        <x-input.select-color :items="$colors" wire:model.live="newRecord.color_id"/>

                    </div>
                    <div class="my-1">
                        <x-input.label class="my-2" value="{{ __('Task content') }}" />
                        <x-input.div-editable wire:model="newRecord.content" editable="true" >{!! $newRecord['content'] !!}</x-input.div-editable>
                        @error('content') <x-error>{{ $message }}</x-error> @enderror
                    </div>
                    <div class="my-1 sm:grid sm:grid-cols-[100px_minmax(0,_1fr)] items-center">
                        <x-input.label>Дата</x-input.label>
                        <x-input.text type="date" min="1970-01-01" max="2124-12-31" wire:model.blur="newRecord.day" />
                    </div>
                    <div class="my-1 sm:grid sm:grid-cols-[100px_minmax(0,_1fr)] items-center">
                        <x-input.label>Начало</x-input.label>
                        <x-input.text type="time" wire:model.blur="newRecord.start" />
                        @error('start') <x-error class="col-span-2">{{ $message }}</x-error> @enderror
                    </div>
                    <div class="my-1 sm:grid sm:grid-cols-[100px_minmax(0,_1fr)] items-center">
                        <x-input.label>Завершение</x-input.label>
                        <x-input.text type="time" wire:model.blur="newRecord.end" />
                        @error('end') <x-error class="col-span-2">{{ $message }}</x-error> @enderror
                    </div>
                    <div class="flex mt-4">
                        <x-button.create>{{ __('Save Task') }}</x-button.create>
                        <x-button.secondary wire:click="closeCreate">{{ __('Cancel') }}</x-button.secondary>
                    </div>
                </form>
            </div>
        </div>
    </x-sidebar>

</div>
