@props([
    'model',
    'label' => null,
    'placeholder' => '',
])
@if($label)
    <label for="{{ md5($label) }}" class="cursor-pointer">{{ $label }}</label>
@endif
<input type="text"
       @if($label) id="{{ md5($label) }}" @endif
       placeholder="{{ $placeholder }}"
       wire:model="{{ $model }}"
    {{ $attributes->thatStartWith('wire:') }}
    @class(['border-red-500' => $errors->has($model)])>
@error($model)
<span class="error">{{ $message }}</span>
@enderror
