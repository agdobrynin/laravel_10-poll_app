<div class="mt-4">
    @forelse ($polls as $poll)
        <div class="mb-4 bg-slate-100 rounded-md px-6 py-2">
            <h3 class="mb-4 text-xl">
                {{ $poll->title }}
            </h3>
            @foreach ($poll->options as $option)
                <div class="mb-2 flex gap-2 justify-between border p-2 bg-white rounded-md hover:shadow-md">
                    <div>{{ $option->name }} ({{ $option->votes->count() }})</div>
                    <button class="btn" wire:click="vote({{ $option->id }})">Vote</button>
                </div>
            @endforeach
        </div>
    @empty
        <div class="text-gray-500">
            No polls available
        </div>
    @endforelse
    <div>
        {{ $polls->links() }}
    </div>
</div>
