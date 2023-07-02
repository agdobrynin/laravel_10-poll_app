<div class="mt-4">
    @if ($polls)
        <div class="mb-4">
            <label for="filter-input">Filter by poll title</label>
            <input id= "filter-input" placeholder="Search string here" type="text" wire:model="search">
        </div>
    @endif
    @forelse ($polls as $poll)
        <div class="mb-4 bg-slate-100 rounded-md px-6 py-2">
            <h3 class="mb-4 text-xl">
                Poll: &laquo;{{ $poll->title }}&raquo;
            </h3>
            <div class="text-gray-400 mb-4">click on the option to vote</div>
            @foreach ($poll->options as $option)
                <div class="mb-2 flex gap-2 justify-between border p-2 bg-white rounded-md hover:shadow-md">
                    <div class="cursor-pointer underline underline-offset-1 decoration-indigo-400 hover:underline-offset-4 hover:decoration-indigo-600" wire:click.prevent="vote({{ $option->id }})">
                        {{ $option->name }}
                    </div>
                    <div>{{ $option->votes->count() }} {{ \Illuminate\Support\Str::plural('vote', $option->votes->count()) }}</div>
                </div>
            @endforeach
        </div>
    @empty
        <div class="text-gray-500">
            No polls available
        </div>
    @endforelse
    <div>
        {{ $polls->onEachSide(1)->links() }}
    </div>
</div>
