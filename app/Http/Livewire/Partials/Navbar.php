<?php

namespace App\Http\Livewire\Partials;

use App\Helpers\CartMangement;
use Livewire\Component;


class Navbar extends Component
{

    public $total_count=0;
    public function mount(){
        $this->total_count=count(CartMangement::getCartItemsFromCookie());
    }


    protected $listeners = [
        'update-cart-count' => 'updateCartCount'
    ];
    public function updateCartCount($total_count)
    {
        $this->total_count = $total_count;
    }
    

    
    
    public function render()
    {
        return view('livewire.partials.navbar');
    }
}
