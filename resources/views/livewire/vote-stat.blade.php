<div>
    <div wire:loading.remove>
        Total {{ $voteCount }} {{ \Illuminate\Support\Str::plural('vote', $voteCount) }}
    </div>
    <div wire:loading.delay>
        <x-loader />
    </div>
</div>
