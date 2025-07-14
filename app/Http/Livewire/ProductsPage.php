<?php

namespace App\Http\Livewire;

use Livewire\Attributes\On;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Http\Livewire\Partials\Navbar;
use App\Helpers\CartMangement;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;
use function Ramsey\Uuid\v3;

class ProductsPage extends Component
{

    use LivewireAlert;
    use WithPagination;

    public $selected_categories = [];
    public $selected_brands = [];
    public $featured;
    public $on_sale;

    public $price_range = 5000; // Startwert
    public $minPrice = 50;       // Startwert für den Filter
    public $maxPrice = 6000;   // Endwert für den Filter
    
    public $sort = 'latest';

    // add product to cart method
    public function addToCart($product_id)
    {
        $total_count = CartMangement::addItemsToCart($product_id);
        $this->emit('update-cart-count', $total_count);

        // $this->alert('success','Product added to the cart successfully!',[
        //     'position'=>'bottom-end',
        //     'timer'=>3000,
        //     'toast'=>true,

        // ]);
    }    
        public function testAlert()
{
    $this->alert('success', 'Product added to the cart successfully!', [
        'position' => 'top-end',
        'timer' => 2000,
        'toast' => true,
    ]);
}


    // dd($product_id);


    
    
    public function mount()
    {
        // Optional: Dynamisch aus der Datenbank holen
        // $this->minPrice = Product::min('price') ?? 50;
        // $this->maxPrice = Product::max('price') ?? 500000;
        $this->price_range = $this->maxPrice; // Standardmäßig auf Maximum setzen
    }

    public function render()
    {
        $productQuery = Product::query()->where('is_active', 1);

        if (!empty($this->selected_categories)) {
            $productQuery->whereIn('category_id', $this->selected_categories);
        }

        if (!empty($this->selected_brands)) {
            $productQuery->whereIn('brand_id', $this->selected_brands);
        }

        if ($this->featured) {
            $productQuery->where('is_Featured', 1);
        }

        if ($this->on_sale) {
            $productQuery->where('on_sale', 1);
        }

        if ($this->price_range) {
            $productQuery->whereBetween('price', [$this->minPrice, $this->price_range]);
        }

        if($this->sort=='latest'){
            $productQuery->latest();
        }

        if($this->sort=='price'){
            $productQuery->orderBy('price');
        }

 // Filter nach Preis





        return view('livewire.products-page', [
            'products' => $productQuery->paginate(6),
            'brands' => Brand::where('is_active', 1)->get(['id', 'name', 'slug']),
            'categories' => Category::where('is_active', 1)->get(['id', 'name', 'slug']),
            'minPrice' => $this->minPrice,
            'maxPrice' => $this->maxPrice,
            'price_range' => $this->price_range,
        ]);    
    }


}
