<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\VoteStat;
use App\Models\Option;
use App\Models\Poll;
use App\Models\Vote;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class VoteStatTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function the_component_can_render(): void
    {
        Livewire::test(VoteStat::class)
            ->assertOk();
    }

    /** @test */
    public function the_component_can_see_on_main_page(): void
    {
        $this->get('/')
            ->assertSeeLivewire(VoteStat::class);
    }

    /** @test */
    public function the_component_can_see_create_new_poll_page(): void
    {
        $this->get('/polls/create')
            ->assertSeeLivewire(VoteStat::class);
    }

    /** @test */
    public function show_count_votes(): void
    {
        Poll::factory(2)
            ->has(
                Option::factory(2)
                    ->has(Vote::factory(4))
            )
            ->create();

        Livewire::test(VoteStat::class)
            ->assertViewHas('voteCount', 16);
    }
}
