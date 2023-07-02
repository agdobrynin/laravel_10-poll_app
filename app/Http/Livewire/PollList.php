<?php

namespace App\Http\Livewire;

use App\Models\Option;
use App\Models\Poll;
use Livewire\Component;

class PollList extends Component
{
    public function vote(Option $option): void
    {
        $option->votes()->create();
    }

    public function render()
    {
        $polls = Poll::with('options.votes')
            ->latest()->paginate(1);

        return view('livewire.poll-list', ['polls' => $polls])
            ->layout('app');
    }
}
