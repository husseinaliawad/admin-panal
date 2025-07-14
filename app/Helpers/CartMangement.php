<?php 

namespace App\Helpers;

use App\Models\Product;
use Illuminate\Support\Facades\Cookie;

class CartMangement{

// add item to cart----------------------------------------------------------------------
static public function addItemsToCart($product_id)
{
    // Stelle sicher, dass wir immer ein Array haben
    $cart_items = self::getCartItemsFromCookie();
    if (!is_array($cart_items)) {
        $cart_items = [];
    }

    $existing_item = null;

    foreach ($cart_items as $key => $item) {
        if ($item['product_id'] == $product_id) {
            $existing_item = $key;
            break;
        }
    }

    if ($existing_item !== null) {
        $cart_items[$existing_item]['quantity']++;
        $cart_items[$existing_item]['total_amount'] = $cart_items[$existing_item]['quantity'] *
            $cart_items[$existing_item]['unit_amount'];
    } else {
        $product = Product::where('id', $product_id)->first(['id', 'name', 'price', 'images']);

        if ($product) {
            $cart_items[] = [
                'product_id'   => $product_id,
                'name'         => $product->name,
                // 'image'        => is_array($product->images) ? $product->images[0] : $product->images,
                'image' =>           is_array($product->images) 
                                    ? (isset($product->images[0]) ? (string)$product->images[0] : '') 
                                    : (string)$product->images,

                'quantity'     => 1,
                'unit_amount'  => $product->price,
                'total_amount' => $product->price
            ];
        }
    }

    self::addCartItemsToCookie($cart_items);
    return count($cart_items);
}

// add item to cart----------------------------------------------------------------------
static public function addItemToCartWithQty($product_id,$qty =1)
{
    // Stelle sicher, dass wir immer ein Array haben
    $cart_items = self::getCartItemsFromCookie();
    if (!is_array($cart_items)) {
        $cart_items = [];
    }

    $existing_item = null;

    foreach ($cart_items as $key => $item) {
        if ($item['product_id'] == $product_id) {
            $existing_item = $key;
            break;
        }
    }

    if ($existing_item !== null) {
        $cart_items[$existing_item]['quantity']=$qty;
        $cart_items[$existing_item]['total_amount'] = $cart_items[$existing_item]['quantity'] *
            $cart_items[$existing_item]['unit_amount'];
    } else {
        $product = Product::where('id', $product_id)->first(['id', 'name', 'price', 'images']);

        if ($product) {
            $cart_items[] = [
                'product_id'   => $product_id,
                'name'         => $product->name,
                'image'        => is_array($product->images) ? $product->images[0] : $product->images,
                'quantity'     => $qty,
                'unit_amount'  => $product->price,
                'total_amount' => $product->price * $qty
            ];
        }
    }

    self::addCartItemsToCookie($cart_items);
    return count($cart_items);
}





// remove item from cart---------------------------------------------------------------
static public function removeCartItem($product_id)
{
    $cart_items = self::getCartItemsFromCookie();
    foreach ($cart_items as $key => $item) {
        if ($item['product_id'] == $product_id) {
            unset($cart_items[$key]);
            break;
        }
    }
    $cart_items = array_values($cart_items); // Neu indizieren!
    self::addCartItemsToCookie($cart_items);
    return $cart_items;
}





// add cart items to cookie --------------------------------------------------------
static public function addCartItemsToCookie($cart_items){
    Cookie::queue('cart_items',json_encode($cart_items),60 * 24 * 30);
}


// clear cart items from cookie----------------------------------------------------------------

static public function clearCartItems(){
    Cookie::queue(Cookie::forget('cart_items'));
}


// get all cart items from cookie ------------------------------------------------------

static public function getCartItemsFromCookie()
{
    $cart_items_json = Cookie::get('cart_items');
    if ($cart_items_json === null) {
        return [];
    }
    $cart_items = json_decode($cart_items_json, true);
    return is_array($cart_items) ? $cart_items : [];
}




// increment item quantity --------------------------------------------------------------

static public function incrementQuantityToCartItem($product_id)
{
    $cart_items = self::getCartItemsFromCookie();
 

    foreach ($cart_items as $key => $item) {
        if ($item['product_id'] == $product_id) {
            $cart_items[$key]['quantity']++;
            $cart_items[$key]['total_amount'] = $cart_items[$key]['quantity'] * $cart_items[$key]['unit_amount'];
            // break;
        }
    }

    self::addCartItemsToCookie($cart_items);

    // Rückgabe: Neue Menge des Artikels oder Anzahl aller Artikel
    // return $cart_items[$key]['quantity'] ?? 0;
    return $cart_items;
}



// decrement item quantity----------------------------------------------------------------

static public function decrementQuantityToCartItem($product_id)
{
    $cart_items = self::getCartItemsFromCookie();

    foreach ($cart_items as $key => $item) {
        if ($item['product_id'] == $product_id) {
            if($cart_items[$key]['quantity']>1){
            // Menge verringern
            $cart_items[$key]['quantity']--;
                // Gesamtpreis aktualisieren
                $cart_items[$key]['total_amount'] = $cart_items[$key]['quantity'] * $cart_items[$key]['unit_amount'];
            }
            // break;
        }
    }

    self::addCartItemsToCookie($cart_items);
 // Rückgabe: Neue Menge des Artikels oder 0, falls entfernt
    return $cart_items;
   
}



// calculate grand total-------------------------------------------------------------------

static public function calculateGrandTotal($items)
{
    return array_sum(array_column($items,'total_amount'));
}

// refresh cart totals (fix any calculation issues)-----------------------------------
static public function refreshCartTotals()
{
    $cart_items = self::getCartItemsFromCookie();
    
    foreach ($cart_items as $key => $item) {
        $cart_items[$key]['total_amount'] = $item['unit_amount'] * $item['quantity'];
    }
    
    self::addCartItemsToCookie($cart_items);
    return $cart_items;
}



}