<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Task') }}
        </h2>
    </x-slot>
 
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg px-4 py-4">
                    <x-validation-errors class="mb-4" />
 
                    <form method="POST" action="{{ route('tasks.update', $task) }}">
                        @csrf
                        @method('PUT')

                        <div>
                            <x-label for="name" value="{{ __('Task name') }}" />
                            <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="$task->name" required autofocus autocomplete="name" />
                        </div>
 
                        <div class="flex mt-4">
                            <x-button.create>
                                {{ __('Save Task') }}
                            </x-button.create>
                            <x-button.secondary onclick="window.location='{{ route('tasks.index') }}'">
                                {{ __('Cancel') }}
                            </x-button.secondary>
                        </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>