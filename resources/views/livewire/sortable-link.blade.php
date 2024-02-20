<div class="flex text-cyan-900 dark:text-cyan-200 text-xs">
    <span class="underline {{ isset($direction) ? 'decoration-solid' : 'decoration-dotted' }} hover:cursor-pointer" title="Сортировать" wire:click="sort">Тест {{ $direction }}</span>
    @isset($direction)
        @if ($direction=='desc')
            <span><svg class="h-4 w-4"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <polyline points="18 15 12 9 6 15" /></svg></span>
        @else
            <span><svg class="h-4 w-4"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <polyline points="6 9 12 15 18 9" /></svg></span>
        @endif
    @endisset
</div>
