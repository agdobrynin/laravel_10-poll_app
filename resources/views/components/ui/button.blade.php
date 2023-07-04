@props([
    'text',
    'loader_target' => null,
])
<button
    {{ $attributes->merge(['class' => '']) }}
    {{ $attributes->thatStartWith('wire:') }}>
    {{ $text }}
    <span wire:loading @if(is_string($loader_target)) wire:target="{{ $loader_target }}"@endif>
        <x-ui.loader/>
    </span>
</button>
