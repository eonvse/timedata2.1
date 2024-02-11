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
                            <x-table.head>{{ __('Created_at') }}</x-table.head>
                            <x-table.head>{{ __('Autor') }}</x-table.head>
                            @can('manage tasks')
                            <x-table.head>

                            </x-table.head>
                            @endcan
                        </x-slot>
                        @forelse ($tasks as $task)
                            <x-table.row>
                                <x-table.cell class="flex items-center">
                                    <div class="w-4 mx-1 {{ $task->color->base ?? '' }} dark:{{ $task->color->dark ?? '' }}">&nbsp;</div>
                                    <div><x-link.table-cell href="{{ route('tasks.edit', $task) }}" title="{{ __('Edit') }}">{{ $task->name }}</x-link.table-cell></div>
                                </x-table.cell>
                                <x-table.cell>{{ $task->created }}</x-table.cell>
                                <x-table.cell>{{ $task->autor->name }}</x-table.cell>
                                @can('manage tasks')
                                <x-table.cell>
                                    <div class="flex items-center">
                                    <x-link.icon-edit href="{{ route('tasks.edit', $task) }}" title="{{ __('Edit') }}" />
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
