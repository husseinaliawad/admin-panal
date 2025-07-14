<?php

namespace App\Http\Livewire;

use App\Models\OrderItem;
use App\Models\Address;
use Livewire\Component;
use App\Models\Order;


class MyorderDetailPage extends Component
{


    public $order_id;

    public function mount($order_id){
        $this->order_id=$order_id;
        // dd($this->order_id);
    }
    public function render()
    {
        $order_items=OrderItem::with('product')->where('order_id', $this->order_id)->get();
        $address=Address::where('order_id',$this->order_id)->first();
        $order=Order::where('id',$this->order_id)->first();
        return view('livewire.myorder-detail-page',[
            'order_items' => $order_items,
            'address' =>$address,
            'order' => $order
        ]);
    }
}
