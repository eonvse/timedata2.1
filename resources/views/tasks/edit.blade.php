<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Task') }}
        </h2>
    </x-slot>

    <div class="py-3">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="{{ $task->color->base }} dark:{{ $task->color->dark }}overflow-hidden shadow-xl sm:rounded-lg">
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg px-4 py-4 ">
                    <div class="sm:grid sm:grid-cols-6 p-2 bg-neutral-200 ">
                        <div class="col-span-2">name {{ $task->name }}</div>
                        <div class="p-1 border border-black">autor_id {{ $task->autor_id }}</div>
                        <div class="p-1 border border-black">team_id {{ $task->team_id }}</div>
                        <div class="p-1 {{ $task->color->base }} dark:{{ $task->color->dark }} border border-black"">color_id {{ $task->color_id }}</div>
                        <div class="row-span-2 grid items-center p-1">
                            <div>Кнопки-действия</div>
                        </div>
                        <div class="p-1 border border-black">day {{ $task->day }}</div>
                        <div class="p-1 border border-black">start {{ $task->start }}</div>
                        <div class="p-1 border border-black">end {{ $task->end }}</div>
                        <div class="p-1 border border-black">isDone {{ $task->isDone }}</div>
                        <div class="p-1 border border-black">dateDone {{ $task->dateDone }}</div>

                    </div>
                    <div class="bg-white sm:grid sm:grid-cols-3">
                        <div class="row-span-2 border p-2">content {{ $task->content }}</div>
                        <div class="min-h-40 border p-2">Заметки + livewire button</div>
                        <div class="min-h-40 border p-2">Events</div>
                        <div class="min-h-40 border p-2">Файлы + livewire button</div>
                        <div class="min-h-40 border p-2">
                            <p>Статистика (на подумать)...</p>
                            <p>Процесс выполнения ???</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

