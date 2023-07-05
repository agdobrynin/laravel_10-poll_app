<?php

namespace App\Http\Livewire;

use App\Models\Option;
use App\Models\Poll;
use App\Services\FlashMessageSuccess;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

class PollList extends Component
{
    use WithPagination;

    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function vote(Option $option, FlashMessageSuccess $flashMessageSuccess): void
    {
        $option->votes()->create();
        $this->emit(VoteStat::LISTENER_VOTE_CALC);
        $flashMessageSuccess->add('Your vote has been accepted');
    }

    public function render()
    {
        $polls = Poll::when(
            $this->search,
            function (Builder $builder) {
                return $builder
                    ->where('title', 'like', '%' . $this->search . '%')
                    ->orWhereHas(
                        'options',
                        fn(Builder $query) => $query->where('name', 'like', '%' . $this->search . '%')
                    );
            }
        )
            ->with('options.votes')
            ->latest();

        return view('livewire.poll-list', ['polls' => $polls->paginate(1)])
            ->layout('app');
    }
}
