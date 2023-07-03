<div class="mt-4">
    @if ($polls)
        <div class="mb-4">
            <label for="filter-input">Filter by poll title</label>
            <input id= "filter-input" placeholder="Search string here" type="text" wire:model="search">
        </div>
    @endif

    <div wire:loading wire:target="gotoPage,search">
        <x-loader message="Updating..." />
    </div>

        @forelse ($polls as $poll)
        <div wire:key="poll-{{ $poll->id }}"
             wire:loading.remove
             wire:target="gotoPage,search"
             class="mb-4 bg-slate-100 rounded-md px-6 py-2">
            <h3 class="mb-4 text-xl">
                Poll: &laquo;{{ $poll->title }}&raquo;
            </h3>
            <div class="text-gray-400 mb-4">click on the option to vote</div>
            @foreach ($poll->options as $option)
                <div wire:key="option-{{ $option->id }}" class="mb-2 vote-option">
                    <div class="vote-link"
                         wire:loading.remove
                         wire:target="vote"
                         wire:click.prevent="vote({{ $option->id }})">
                        {{ $option->name }}
                    </div>
                    <div wire:loading
                         wire:target="vote"><x-loader /></div>
                    <div>
                        {{ $option->votes->count() }}
                        {{ \Illuminate\Support\Str::plural('vote', $option->votes->count()) }}
                    </div>
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
