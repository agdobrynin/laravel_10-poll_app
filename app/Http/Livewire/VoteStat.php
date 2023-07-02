<?php

namespace App\Http\Livewire;

use App\Models\Vote;
use Livewire\Component;

class VoteStat extends Component
{
    public const VOTE_CALC = 'vote-calc';

    public int $voteCount = 0;

    protected $listeners = [self::VOTE_CALC => 'calc'];

    public function mount()
    {
        $this->calc();
    }

    public function calc(): void
    {
        $this->voteCount = Vote::count();
    }

    public function render()
    {
        return view('livewire.vote-stat');
    }
}
