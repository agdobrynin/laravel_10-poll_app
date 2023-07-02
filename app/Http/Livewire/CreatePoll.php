<?php

namespace App\Http\Livewire;

use App\Models\Poll;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class CreatePoll extends Component
{
    /**
     * @var string
     */
    public $title;
    /**
     * @var string[]
     */
    public $options = [];

    protected array $rules = [
        'title' => 'required|string|min:6',
        'options' => 'required|array|min:2',
        'options.*' => 'required|string|min:2'
    ];

    /**
     * @throws ValidationException
     */
    public function updated($propertyName): void
    {
        $this->validateOnly($propertyName);
    }
    public function addOption(): void
    {
        $this->options[] = '';
    }

    public function removeOption(int $index): void
    {
        unset($this->options[$index]);
        $this->options = array_values($this->options);
    }

    public function createPoll()
    {
        $this->validate();

        Poll::create(['title' => $this->title])
            ->options()
            ->createMany(
                array_map(fn(string $name) => ['name' => $name], $this->options)
            );

        $this->reset(['title', 'options']);

        return redirect()->to('/');
    }

    public function render()
    {
        return view('livewire.create-poll')
            ->layout('app');
    }
}
