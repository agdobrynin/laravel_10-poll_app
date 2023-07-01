<?php

namespace App\Http\Livewire;

use Livewire\Component;

class CreatePool extends Component
{
    public ?string $title;
    public function render()
    {
        return view('livewire.create-pool');
    }
}
