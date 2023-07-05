<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\PollList;
use App\Models\Option;
use App\Models\Poll;
use App\Models\Vote;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class PollListTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function component_can_render(): void
    {
        Livewire::test(PollList::class)
            ->assertOk();
    }

    /** @test */
    public function the_component_can_see_on_main_page(): void
    {
        $this->get('/')
            ->assertSeeLivewire(PollList::class);
    }

    /** @test */
    public function poll_pagination(): void
    {
        Poll::factory(4)
            ->has(Option::factory(2))
            ->create();

        Livewire::test(PollList::class)
            ->assertSeeHtml('<nav role="navigation"')
            ->assertSeeHtml('wire:click="nextPage(\'page\')"')
            ->assertSeeHtml('<span wire:key="paginator-page-1-page1">')
            ->assertSeeHtml('<span wire:key="paginator-page-1-page2">')
            ->assertSeeHtml('<span wire:key="paginator-page-1-page3">')
            ->assertSeeHtml('<span wire:key="paginator-page-1-page4">')
            ->assertDontSeeHtml('<span wire:key="paginator-page-1-page5">');
    }

    /** @test */
    public function filter_by_poll_title(): void
    {
        Poll::factory(2)
            ->sequence(['title' => 'The abc poll'], ['title' => 'Poll for dfj show'])
            ->create();

        Livewire::test(PollList::class)
            ->set('search', 'dfj')
            ->assertViewHas('search', 'dfj')
            ->assertSee('Poll for dfj show')
            ->assertDontSee('The abc poll')
            ->assertDontSeeHtml('<nav role="navigation"')
            ->assertDontSeeHtml('<span wire:key="paginator-page-1-page1">');
    }

    /** @test */
    public function filter_by_poll_title_and_option_name(): void
    {
        Poll::factory(state: ['title' => 'The first poll, right?'])
            ->has(Option::factory(2))
            ->create();

        Poll::factory()
            ->has(
                Option::factory(2)
                    ->sequence([], ['name' => 'Yes it is my first poll today'])
            )
            ->create();

        Livewire::test(PollList::class)
            ->set('search', 'first poll')
            ->assertViewHas('search', 'first poll')
            ->assertSee('The first poll, right?')
            ->assertDontSee('Yes it is my first poll today')
            ->assertSeeHtml('<nav role="navigation"')
            ->assertSeeHtml('wire:click="nextPage(\'page\')"')
            ->assertSeeHtml('<span wire:key="paginator-page-1-page1">')
            ->assertSeeHtml('<span wire:key="paginator-page-1-page2">')
            ->assertDontSeeHtml('<span wire:key="paginator-page-1-page3">')
            // Go to page two! (emulate click)
            ->call('gotoPage', 2, 'page')
            ->assertDontSee('The first poll, right?')
            ->assertSee('Yes it is my first poll today')
            ->assertDontSeeHtml('<span wire:key="paginator-page-1-page3">')
            ->assertSeeHtml('wire:click="previousPage(\'page\')"');
    }

    /** @test  */
    public function vote_success(): void
    {
        /** @var Poll $poll */
        $poll = Poll::factory()
            ->has(Option::factory(6))
            ->create();

        /** @var Collection<Option> $pollOptions */
        $pollOptions = $poll->options;

        Livewire::test(PollList::class)
            ->call('vote', $pollOptions->values()->get(0))
            ->assertEmitted('calc')
            ->call('vote', $pollOptions->values()->get(1))
            ->assertEmitted('calc')
            ->call('vote', $pollOptions->values()->get(1))
            ->assertEmitted('calc')
            ->call('vote', $pollOptions->values()->get(5))
            ->assertEmitted('calc');

        $votes = $poll->hasManyThrough(Vote::class, Option::class)
            ->count();

        $this->assertEquals(4, $votes);
    }
}
