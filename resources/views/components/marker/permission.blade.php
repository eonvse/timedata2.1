@props(['name'=>'default'])

@php
$type = empty($name) ? 'default' : explode('.',$name)[0];
$types = [
    'default' => 'bg-blue-500 text-white',
    'role' => 'bg-yellow-200 text-black',
    'task' => 'bg-sky-200 text-black',
    'user' => 'bg-green-200 text-black',
];
@endphp

<span class="{{ $types[$type] }} rounded p-1">{{ $slot }}</span>
