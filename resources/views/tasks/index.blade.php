<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tasks list') }}
        </h2>
    </x-slot>
 
    <div class="py-3">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    @can('manage tasks')
                    <livewire:tasks.create />
                    @endcan
                    <x-table>
                        <x-slot name="header">
                            <x-table.head>
                                {{ __('Task name') }}
                            </x-table.head>
                            @can('manage tasks')
                            <x-table.head>
 
                            </x-table.head>
                            @endcan
                        </x-slot>
                        @forelse ($tasks as $task)
                            <x-table.row>
                                <x-table.cell>
                                    {{ $task->name }}
                                </x-table.cell>
                                @can('manage tasks')
                                <x-table.cell>
                                    <div class="flex items-center">
                                    <x-link.icon-edit href="{{ route('tasks.edit', $task) }}" title="{{ __('Edit') }}" />
                                    <form method="POST" action="{{ route('tasks.destroy', $task) }}" class=" flex items-center">
                                        @csrf
                                        @method('DELETE')
                                        <x-button.icon-del type="submit" onclick="return confirm('Are you sure?')" title="{{ __('Delete') }}" />
                                    </form>
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
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
