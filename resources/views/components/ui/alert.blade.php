@props([
    'message',
])
<div id="{{ md5($message) }}" class="alert-success mb-4" wire:click="$refresh">
    {{ $message }}
</div>
