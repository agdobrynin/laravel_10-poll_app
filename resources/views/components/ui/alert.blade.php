@props([
    'message',
])
<div id="{{ md5($message) }}" {{ $attributes->merge(['class' => 'alert mb-4 relative']) }}>
    <button type="button" class="absolute top-2 right-4" onclick="this.parentNode.remove()">
        <span class="sr-only">Close menu</span>
        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>
    <p>{{ $message }}</p>
</div>
