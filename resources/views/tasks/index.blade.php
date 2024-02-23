<x-app-layout>
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
                    <livewire:tasks.create />
                    @endcan
                    <x-table>
                        <x-slot name="header">
                            <x-table.head>
                                {{ __('Task name') }}
                            </x-table.head>
                            <x-table.head class="text-center">
                                <div class="flex justify-center">
                                    <livewire:sortable-link text="{{ __('Event Day') }}" list="tasks" field="day" :sortField="$sortField" :sortDirection="$sortDirection" />
                                </div>
                            </x-table.head>
                            <x-table.head class="text-center">{{ __('Task time') }}</x-table.head>
                            <x-table.head class="text-center">
                                <div class="flex justify-center">
                                    <livewire:sortable-link text="{{ __('Created_at') }}" list="tasks" field="created_at" :sortField="$sortField" :sortDirection="$sortDirection" />
                                </div>
                            </x-table.head>
                            <x-table.head>{{ __('Autor') }}</x-table.head>
                            @can('manage tasks')
                            <x-table.head>

                            </x-table.head>
                            @endcan
                        </x-slot>
                        @forelse ($tasks as $task)
                            <x-table.row>
                                <x-table.cell>
                                    <div class="flex items-center">
                                        <div class="w-4 mx-1 {{ $task->color->base ?? '' }} dark:{{ $task->color->dark ?? '' }}">&nbsp;</div>
                                        <div><x-link.table-cell href="{{ route('tasks.edit', $task) }}" title="{{ __('Edit') }}">{{ $task->name }}</x-link.table-cell></div>
                                    </div>
                                </x-table.cell>
                                <x-table.cell class="tabular-nums text-center">{{ $task->day_format }}</x-table.cell>
                                <x-table.cell class="tabular-nums text-center">
                                    <div class="grid grid-cols-2">
                                        <div>{{ $task->start_format }}</div>
                                        <div>{{ $task->end_format }}</div>
                                    </div>
                                </x-table.cell>
                                <x-table.cell class="tabular-nums text-center">{{ $task->created }}</x-table.cell>
                                <x-table.cell>{{ $task->autor->name }}</x-table.cell>
                                @can('manage tasks')
                                <x-table.cell>
                                    <div class="flex items-center">
                                    <x-link.icon-edit href="{{ route('tasks.edit', ['task'=>$task, 'editable'=>1]) }}" title="{{ __('Edit') }}" />
                                    <livewire:tasks.delete :$task />
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
                    <div class="m-2">{{ $tasks->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
