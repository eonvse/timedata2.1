<div>
    <div class="sm:grid sm:grid-cols-6 p-2 bg-neutral-200">
        <div class="col-span-2">name {{ $data['name'] }}</div>
        <div class="p-1 {{ $task->color->base }} dark:{{ $task->color->dark }} border border-black">color_id {{ $data['color_id'] }}</div>
        <div class="p-1 border border-black">team_id {{ $data['team_id'] }}</div>
        <div class="p-1 border border-black">{{ __('Autor') }} {{ $task->autor->name }}</div>
        <div class="row-span-2 grid items-center p-1">
            <div>Кнопки-действия</div>
            {{ $editable ? 'editable' : '' }}
        </div>
        <div class="p-1 border border-black">day {{ $data['day'] }}</div>
        <div class="p-1 border border-black">start {{ $data['start'] }}</div>
        <div class="p-1 border border-black">end {{ $data['end'] }}</div>
        <div class="p-1 border border-black">isDone {{ $data['isDone'] }}</div>
        <div class="p-1 border border-black">dateDone {{ $data['dateDone'] }}</div>
    </div>
</div>
