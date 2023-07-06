<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\PollList;
use App\Models\Option;
use App\Models\Poll;
use App\Models\Vote;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
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

        /** config rate limit for vote action */
        Config::set('poll_app.limit.vote.max_attempts', 0);

        Livewire::test(PollList::class)
            ->call('vote', $pollOptions->values()->get(0))
            ->assertEmitted('calc')
            ->call('vote', $pollOptions->values()->get(1))
            ->assertEmitted('calc')
            ->call('vote', $pollOptions->values()->get(1))
            ->assertEmitted('calc')
            ->call('vote', $pollOptions->values()->get(5))
            ->assertEmitted('calc')
            ->assertSee('Your vote has been accepted');

        $votes = $poll->hasManyThrough(Vote::class, Option::class)
            ->count();

        $this->assertEquals(4, $votes);
    }

    /** @test  */
    public function vote_rate_limit(): void
    {
        /** @var Poll $poll */
        $poll = Poll::factory()->has(Option::factory())->create();

        /** @var Option $option */
        $option = $poll->options->first();

        /** config rate limit for vote action */
        Config::set('poll_app.limit.vote.max_attempts', 1);

        Livewire::test(PollList::class)
            ->call('vote', $option->id)
            ->assertEmitted('calc')
            ->assertSee('Your vote has been accepted')
            ->call('vote',  $option->id)
            ->assertNotEmitted('calc')
            ->assertSee('Too many request. Retry after')
            ->call('vote',  $option->id)
            ->assertNotEmitted('calc')
            ->assertSee('Too many request. Retry after')
            ->call('vote',  $option->id)
            ->assertNotEmitted('calc')
            ->assertSee('Too many request. Retry after');

        $votes = $poll->hasManyThrough(Vote::class, Option::class)
            ->count();
        $this->assertEquals(1, $votes);
    }

    /** @test  */
    public function navigation_previous_next_pages(): void
    {
        Poll::factory(2)
            ->has(Option::factory(2))
            ->create();

        Livewire::test(PollList::class)
            ->call('nextPage', 'page')
            ->assertOk()
            ->assertSee(Poll::all()->values()->offsetGet(1)->title)
            ->assertDontSee(Poll::all()->values()->offsetGet(0)->title)
            ->call('previousPage', 'page')
            ->assertOk()
            ->assertSee(Poll::all()->values()->offsetGet(0)->title)
            ->assertDontSee(Poll::all()->values()->offsetGet(1)->title);
    }
}
