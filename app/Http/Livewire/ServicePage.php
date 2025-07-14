<?php

namespace App\Http\Livewire;

use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Services - CICS')]
class ServicePage extends Component
{
    public function render()
    {
        return view('livewire.service-page');
    }
}
