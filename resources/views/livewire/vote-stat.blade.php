<div>
    Total {{ $voteCount }} {{ \Illuminate\Support\Str::plural('vote', $voteCount) }}
    <div wire:loading.delay>
        <x-loader />
    </div>
</div>
