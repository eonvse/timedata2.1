<div>
    <form wire:submit="saveContent">
    <div class="text-sm text-neutral-600 flex items-center">
        <div class="text-center grow">{{ __('Task content') }}</div>
        <div class="flex items-center">
            @if ($editable)
                <x-button.icon-ok title="{{ __('Save') }} " />
                <x-button.icon-cancel type="button" wire:click="closeContent" title="{{ __('Cancel') }}" />
            @else
                <x-button.icon-edit type="button" wire:click="openContent" title="{{ __('Edit') }}"/>
            @endif
        </div>

    </div>
    <div>
        @if ($editable)
            <x-input.div-editable wire:model="content" editable="true" >{!! $content !!}</x-input.div-editable>
            @error('content') <x-error>{{ $message }}</x-error> @enderror
        @else
            {!! empty($content) ? __('empty') : $content !!}
        @endif
    </div>
    </form>
</div>
