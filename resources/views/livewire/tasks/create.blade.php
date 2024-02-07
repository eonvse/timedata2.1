<div class="relative overflow-x-auto shadow-md sm:rounded-lg px-4 py-4">
    <x-button.create wire:click="showSidebar">{{ __('Add new task') }}</x-button.create>
    <x-sidebar wire:model="sidebar">
        <div class="w-full p-5 text-center shadow font-semibold text-xl">
            {{ __('Add New Task') }}
        </div>
        <div class="p-10 flex-col space-y-2">
            <div>

                <x-validation-errors class="mb-4" />

                <form wire:submit="save">
                    <input type="hidden" wire:model="team_id" />
                    <input type="hidden" wire:model="isDone" />
                    <div>
                        <x-label for="name" value="{{ __('Task name') }}" />
                        <x-input id="name" class="block mt-1 w-full" type="text" name="name" wire:model="name" required autofocus autocomplete="name" />
                        @error('name') <span class="error">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        @php
                        $colorBg = '';
                        foreach ($colors as $color)
                            if ($color['id']==$color_id) $colorBg = $color['base'].' dark:'.$color['dark'];
                        @endphp
                        <x-label class="flex items-center">
                            Цвет
                            <div class="{{ $colorBg }} w-full m-2">&nbsp;</div>
                        </x-label>
                        <x-input.select-color :items="$colors" wire:model.live="color_id"/>

                    </div>
                    <div class="flex mt-4">
                        <x-button.create>
                            {{ __('Save Task') }}
                        </x-button.create>
                        <x-button.secondary @click="show = false" wire:click="closeSidebar">{{ __('Cancel') }}</x-button.secondary>
                    </div>
                </form>
            </div>
        </div>
    </x-sidebar>
</div>