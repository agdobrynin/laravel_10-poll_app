<?php

namespace Tests\Feature\Livewire;


use App\Http\Livewire\CreatePoll;
use App\Models\Option;
use App\Models\Poll;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class CreatePollTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function the_component_can_render(): void
    {
        Livewire::test(CreatePoll::class)
            ->assertOk();
    }

    /** @test */
    public function the_component_page(): void
    {
        $this->get('/polls/create')
            ->assertSeeLivewire('create-poll')
            ->assertSeeLivewire('vote-stat')
            ->assertDontSeeLivewire('poll-list');
    }

    /** @test */
    public function new_poll_title_is_required(): void
    {
        Livewire::test(CreatePoll::class)
            ->call('createPoll')
            ->assertHasErrors(['title' => 'required']);
    }

    /** @test */
    public function new_poll_title_minimum_of_six_characters_when_submit(): void
    {
        Livewire::test(CreatePoll::class)
            ->set('title', 'abcdf')
            ->call('createPoll')
            ->assertHasErrors(['title' => 'min']);
    }

    /** @test */
    public function new_poll_title_minimum_of_six_characters_when_typing(): void
    {
        Livewire::test(CreatePoll::class)
            ->set('title', 'abcdf')
            ->assertHasErrors(['title' => 'min']);
    }

    /** @test */
    public function new_poll_options_required_when_submit(): void
    {
        Livewire::test(CreatePoll::class)
            ->set('title', 'My poll')
            ->call('createPoll')
            ->assertHasNoErrors(['title'])
            ->assertHasErrors(['options' => ['required']]);
    }

    /** @test */
    public function new_poll_options_minimum_of_two_elements_and_option_name_is_required_when_submit(): void
    {
        Livewire::test(CreatePoll::class)
            ->set('title', 'My poll')
            ->set('options.0', '')
            ->call('createPoll')
            ->assertHasNoErrors(['title'])
            ->assertHasErrors(['options' => 'min'])
            ->assertHasErrors(['options.0' => 'required']);
    }

    /** @test */
    public function new_poll_option_minimum_of_two_characters(): void
    {
        Livewire::test(CreatePoll::class)
            ->set('title', 'First poll')
            ->set('options.0', 'a')
            ->assertHasNoErrors(['title'])
            ->assertHasErrors(['options.0' => 'min']);
    }

    /** @test */
    public function poll_options_add_on_form_and_remove(): void
    {
        Livewire::test(CreatePoll::class)
            ->assertViewHas('options', [])
            ->call('addOption')
            ->set('options.0', 'abcd')
            ->assertViewHas('options', ['abcd'])
            ->call('addOption')
            ->assertViewHas('options', ['abcd', ''])
            ->call('removeOption', 1)
            ->assertViewHas('options', ['abcd'])
            ->call('removeOption', 0)
            ->assertViewHas('options', []);
    }

    /** @test */
    public function new_poll_create_success(): void
    {
        Livewire::test(CreatePoll::class)
            ->set('title', 'My first poll for alphabet')
            ->set('options.0', 'Abc')
            ->set('options.1', 'Dfj')
            ->assertHasNoErrors(['title'])
            ->call('createPoll')
            ->assertStatus(200)
            ->assertSet('title', '')
            ->assertSet('options', []);

        $poll = Poll::whereTitle('My first poll for alphabet');
        $this->assertTrue($poll->exists());
        $pollId = $poll->first()->id;
        $this->assertTrue(Option::whereName('Abc')->where('poll_id', $pollId)->exists());
        $this->assertTrue(Option::whereName('Dfj')->where('poll_id', $pollId)->exists());
    }
}
