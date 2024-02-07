<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Colors') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-neutral-800">
                <div class="grid grid-cols-2">
                    <-- build colors -->
                    <div class="bg-gray-100 dark:bg-gray-200">..</div>
                    <div class="bg-gray-300 dark:bg-gray-400">..</div>
                    <div class="bg-red-100 dark:bg-red-200">..</div>
                    <div class="bg-red-300 dark:bg-red-400">..</div>
                    <div class="bg-orange-100 dark:bg-orange-200">..</div>
                    <div class="bg-orange-300 dark:bg-orange-400">..</div>
                    <div class="bg-yellow-100 dark:bg-yellow-200">..</div>
                    <div class="bg-yellow-300 dark:bg-yellow-400">..</div>
                    <div class="bg-lime-100 dark:bg-lime-200">..</div>
                    <div class="bg-lime-300 dark:bg-lime-400">..</div>
                    <div class="bg-green-100 dark:bg-green-200">..</div>
                    <div class="bg-green-300 dark:bg-green-400">..</div>
                    <div class="bg-cyan-100 dark:bg-cyan-200">..</div>
                    <div class="bg-cyan-300 dark:bg-cyan-400">..</div>
                    <div class="bg-sky-100 dark:bg-sky-200">..</div>
                    <div class="bg-sky-300 dark:bg-sky-400">..</div>
                    <div class="bg-indigo-100 dark:bg-indigo-200">..</div>
                    <div class="bg-indigo-300 dark:bg-indigo-400">..</div>
                    <div class="bg-fuchsia-100 dark:bg-fuchsia-200">..</div>
                    <div class="bg-fuchsia-300 dark:bg-fuchsia-400">..</div>

                </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
