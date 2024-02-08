<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Task') }}
        </h2>
    </x-slot>

    <div class="py-3">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg px-4 py-4">
                    <div class="min-h-40 border p-2 {{ $task->color->base }}">livewire tasks <span class="font-bold text-2xl">{{ $task->name }}</span> form edit</div>
                    <div class="sm:grid sm:grid-cols-3">
                        <div class="min-h-40 border p-2">Заметки + livewire button</div>
                        <div class="min-h-40 border p-2">Файлы + livewire button</div>
                        <div class="min-h-40 border p-2">Статистика (на подумать)</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
