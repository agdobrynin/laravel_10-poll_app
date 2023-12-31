<div class="mt-4">
    @inject('flashMessage', '\App\Services\FlashMessage')
    @if ($msg = $flashMessage->getSuccess())
        <x-ui.alert message="{{$msg}}" class="alert-success"/>
    @endif

    @if ($msg = $flashMessage->getDanger())
        <x-ui.alert message="{{$msg}}" class="alert-danger"/>
    @endif

    @if ($polls)
        <div class="mb-4">
            <label for="filter-input" class="cursor-pointer">Filter by poll title or question name</label>
            <input id="filter-input" placeholder="Search string here" type="text" wire:model="search">
        </div>
    @endif

    <div wire:loading wire:target="gotoPage,search,nextPage,previousPage">
        <x-ui.loader size="6" message="Updating..." />
    </div>

    @forelse ($polls as $poll)
        <div wire:key="poll-{{ $poll->id }}"
             wire:loading.remove
             wire:target="gotoPage,search,nextPage,previousPage"
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
                         wire:target="vote"><x-ui.loader size="6" /></div>
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
