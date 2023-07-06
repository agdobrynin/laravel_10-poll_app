<?php

namespace App\Http\Livewire;

use App\Contracts\RateLimiterInterface;
use App\Exceptions\RateLimiterTooManyRequestException;
use App\Models\Option;
use App\Models\Poll;
use App\Services\FlashMessage;
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

    public function vote(
        Option               $option,
        FlashMessage         $flashMessageSuccess,
        RateLimiterInterface $rateLimiter,
    ): void
    {
        try {
            if ($maxAttempts = config('poll_app.limit.vote.max_attempts')) {
                $key = 'limit-poll-' . $option->poll_id;
                $decaySecond = config('poll_app.limit.vote.decay_seconds');

                $rateLimiter->limit($maxAttempts, $decaySecond, $key);
            }

            $option->votes()->create();
            $this->emit(VoteStat::LISTENER_VOTE_CALC);
            $flashMessageSuccess->addSuccess('Your vote has been accepted');
        } catch (RateLimiterTooManyRequestException $exception) {
            $flashMessageSuccess->addDanger($exception->getMessage());
        }
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
