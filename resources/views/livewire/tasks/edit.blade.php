<div class="bg-neutral-200">
    <x-spinner wire:loading wire:target="store" />
    <x-spinner wire:loading wire:target="openEdit" />
    <x-spinner wire:loading wire:target="cancelEdit" />
    <form wire:submit="store" class="sm:flex">
    <div class="grow mx-2 text-center">
        <div class="sm:grid sm:grid-cols-6  text-sm text-neutral-600">
            <div class="col-span-3">{{ __('Task name') }}</div>
            <div>{{ __('Team Color') }}</div>
            <div>{{ __('Team') }}</div>
            <div>{{ __('Autor') }}</div>
        </div>
        @if ($editable)
        <div class="sm:grid sm:grid-cols-6 font-medium items-center border-b border-neutral-400 border-dashed">
            <div class="col-span-3 p-1">
                <x-input.text wire:model='data.name' />
                @error('name') <x-error>{{ $message }}</x-error> @enderror
            </div>
            <div class="p-1 flex space-x-1">
                @php
                $colorBg = '';
                foreach ($colors as $color)
                    if ($color['id']==$data['color_id']) $colorBg = $color['base'].' dark:'.$color['dark'];
                @endphp
                <div class="{{ $colorBg }} w-4 border border-black">&nbsp;</div>
                <div class="grow"><x-input.select-color :items="$colors" wire:model.live="data.color_id" /></div>

            </div>
            <div class="p-1">{{ $data['team_id'] }}</div>
            <div class="p-1">{{ $task->autor->name }}</div>
        </div>
        <div class="sm:grid sm:grid-cols-6 font-medium">
            <div class="p-1">
                <div class="relative">
                    <x-input.text type="date" min="1970-01-01" max="2124-12-31" wire:model.blur="data.day" />
                    <x-button.icon-clear class="absolute top-0 right-0" title="{{ __('Clear field') }}" wire:click="clearField('day')" />
                </div>
            </div>
            <div class="p-1">
                <div class="relative">
                    <x-input.text type="time" wire:model.blur="data.start" />
                    <x-button.icon-clear class="absolute top-0 right-0" title="{{ __('Clear field') }}" wire:click="clearField('start')" />
                </div>
            </div>
            <div class="p-1">
                <div class="relative">
                    <x-input.text type="time" wire:model.blur="data.end" />
                    <x-button.icon-clear class="absolute top-0 right-0" title="{{ __('Clear field') }}" wire:click="clearField('end')" />
                </div>
            </div>
            <div class="p-1 col-span-2">{{ $data['isDone'] }}</div>
            <div class="p-1">{{ $data['dateDone'] }}</div>
        </div>
        @else
        <div class="sm:grid sm:grid-cols-6 font-medium items-center border-b border-neutral-400 border-dashed">
            <div class="col-span-3">{{ $task->name }}</div>
            <div class="p-2 {{ $task->color->base }} dark:{{ $task->color->dark }}">&nbsp;</div>
            <div class="p-2">{{ $task->team_id }}</div>
            <div class="p-2">{{ $task->autor->name }}</div>
        </div>
        <div class="sm:grid sm:grid-cols-6 font-medium">
            <div class="p-2">{{ empty($task->day) ? '-' : date('d.m.Y', strtotime($task->day)) }}</div>
            <div class="p-2">{{ empty($task->start) ? '-' : date('H:i',strtotime($task->start)) }}</div>
            <div class="p-2">{{ empty($task->end) ? '-' : date('H:i',strtotime($task->end)) }}</div>
            <div class="p-2 col-span-2">{{ $task->isDone }}</div>
            <div class="p-2">{{ empty($task->dateDone) ? '-' : date('d.m.Y',strtotime($task->dateDone)) }}</div>
        </div>
        @endif
        <div class="sm:grid sm:grid-cols-6 text-center text-sm text-neutral-600">
            <div>{{ __('Event Day')}}</div>
            <div>{{ __('Event Start')}}</div>
            <div>{{ __('Event End')}}</div>
            <div class="col-span-2">{{ __('Task isDone')}}</div>
            <div>{{ __('Task dateDone')}}</div>
        </div>
    </div>
    <div class="grid items-center p-2">
        @if ($editable)
        <div class="flex justify-center items-center">
            <x-button.icon-ok type="submit" title="{{ __('Save') }}" />
            <x-button.icon-cancel type="button" wire:click='cancelEdit' title="{{ __('Cancel') }}" />
        </div>
        @else
        <div class="flex justify-center items-center">
            <x-button.icon-edit type="button" wire:click='openEdit' title="{{ __('Edit') }}" />
            <livewire:tasks.delete :$task title="{{ __('Delete') }}" />
        </div>
        @endif
    </div>
    </form>
</div>
