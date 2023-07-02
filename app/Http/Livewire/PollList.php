<?php

namespace App\Http\Livewire;

use App\Models\Option;
use App\Models\Poll;
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

    public function vote(Option $option): void
    {
        $option->votes()->create();
    }

    public function render()
    {
        $polls = Poll::with('options.votes')
            ->where('title', 'like', '%'.$this->search.'%')
            ->latest()
            ->paginate(1);

        return view('livewire.poll-list', ['polls' => $polls])
            ->layout('app');
    }
}
