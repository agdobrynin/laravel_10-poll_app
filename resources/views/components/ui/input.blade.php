@props([
    'model',
    'label' => null,
    'id' => '',
    'placeholder' => '',
])
@if($label)
    <label @if($id) for="{{ $id }}" @endif>{{ $label }}</label>
@endif
<input type="text"
       @if($id) id="{{ $id }}" @endif
       placeholder="{{ $placeholder }}"
       wire:model="{{ $model }}"
    {{ $attributes->thatStartWith('wire:') }}
    @class(['border-red-500' => $errors->has($model)])>
@error($model)
<span class="error">{{ $message }}</span>
@enderror
