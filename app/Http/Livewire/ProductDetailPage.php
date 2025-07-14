<?php

namespace App\Http\Livewire;
use App\Http\Livewire\Partials\Navbar;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Helpers\CartMangement;
use App\Models\Product;
use Livewire\Attributes\Title;
use Livewire\Component;


#[Title('Product Detail - CICS')]
class ProductDetailPage extends Component
{


    use LivewireAlert;
    public $slug ;
    public $quantity=1;


    public function mount($slug){
        $this->slug=$slug;

    }

    public function decreaseQty(){
        if($this->quantity > 1){
            $this->quantity--;
        }
        
    }

    public function increaseQty(){
        $this->quantity++;
    }


    public function addToCart($product_id)
    {
        $total_count = CartMangement::addItemToCartWithQty($product_id, $this->quantity);
    
        // Für Livewire 2: emit statt dispatch!
        $this->emit('update-cart-count', $total_count);
    
        $this->alert('success', 'Product added to the cart successfully!', [
            'position' => 'bottom-end',
            'timer' => 3000,
            'toast' => true,
        ]);
    }
    
    public function render()
    {
        return view('livewire.product-detail-page',[
            'product' => Product::where('slug',$this->slug)->firstOrFail(),
        ]);
    }
}
