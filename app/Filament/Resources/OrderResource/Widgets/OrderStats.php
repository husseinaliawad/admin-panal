<?php

namespace App\Filament\Resources\OrderResource\Widgets;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

use App\Models\Order;

;


use Filament\Widgets\Widget;



class OrderStats extends BaseWidget{
    protected function getCards(): array
    {
        return [
            Card::make('New Order', Order::query()->where('status','new')->count()),
            Card::make('Order Processing', Order::query()->where('status','processing')->count()),
            Card::make('Order Shipped', Order::query()->where('status','shipped')->count()),
            // Card::make('Average Price', Number::currency(Order::query()->avg('grand_total'), 'EUR')) vision fil3
            Card::make('Average Price', number_format(Order::query()->avg('grand_total'), 2) . ' €')


        ];
    }

    
}


// class OrderStats extends Widget
// {
//     protected static string $view = 'filament.resources.order-resource.widgets.order-stats';
// }
