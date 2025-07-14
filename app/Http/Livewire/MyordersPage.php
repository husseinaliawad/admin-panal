<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Order;
use Livewire\WithPagination;


class MyordersPage extends Component
{
    use WithPagination;
    public function render()
    {
        $my_orders=Order::where('user_id',auth()->id())->latest()->paginate(2);
        return view('livewire.myorders-page',[
            'orders'=>$my_orders,
        ]);
    }
}
