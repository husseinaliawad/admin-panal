<?php

namespace App\Http\Livewire;

use App\Helpers\CartMangement;
use Livewire\Component;

class CartPage extends Component
{



    public $cart_items =[];
   

    public $grand_total;

    public function mount(){
        // Refresh cart totals to fix any calculation issues
        $this->cart_items=CartMangement::refreshCartTotals();
        $this->grand_total=CartMangement::calculateGrandTotal($this->cart_items);
    }

    public function removeItem($product_id)
{
    $this->cart_items = CartMangement::removeCartItem($product_id);
    $this->grand_total = CartMangement::calculateGrandTotal($this->cart_items);
    $this->emit('update-cart-count', count($this->cart_items));

}

public function increaseQty($product_id)
{
    $this->cart_items = CartMangement::incrementQuantityToCartItem($product_id);
    $this->grand_total = CartMangement::calculateGrandTotal($this->cart_items);
}

public function decreaseQty($product_id)
{
    $this->cart_items = CartMangement::decrementQuantityToCartItem($product_id);
    $this->grand_total = CartMangement::calculateGrandTotal($this->cart_items);
}

public function render()
{
    // Debug-Ausgabe:
    // dd($this->cart_items);

    return view('livewire.cart-page', [
        'title' => $this->title ?? 'Cart',
    ]);
}

}
