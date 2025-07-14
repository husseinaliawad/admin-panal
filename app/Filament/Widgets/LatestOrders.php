<?php


namespace App\Filament\Widgets;

use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Order; // oder dein Model
use Filament\Tables\Actions\Action;
use App\Filament\Resources\OrderResource;


class LatestOrders extends BaseWidget
{

    protected int |string |array $columnSpan ='full';
    protected static ?int $sort = 1;

    protected function getTableQuery(): Builder
    {
        return Order::query()->latest(); // oder: ->orderBy('created_at', 'desc')
    }

    protected function getTableColumns(): array
    {
        return [
            \Filament\Tables\Columns\TextColumn::make('id')->label('Order ID'),
            \Filament\Tables\Columns\TextColumn::make('user.name')->label('Customer'),
            \Filament\Tables\Columns\TextColumn::make('grand_total')->money('eur'),
            \Filament\Tables\Columns\BadgeColumn::make('status')
                ->colors([
                    'info' => 'new',
                    'warning' => 'processing',
                    'success' => ['shipped', 'delivered'],
                    'danger' => 'cancelled',
                ])
                ->formatStateUsing(fn (string $state): string => match ($state) {
                    'new' => 'New',
                    'processing' => 'Processing',
                    'shipped' => 'Shipped',
                    'delivered' => 'Delivered',
                    'cancelled' => 'Cancelled',
                    default => ucfirst($state),
                }),
            \Filament\Tables\Columns\TextColumn::make('payment_method')->label('Payment Method'),
            \Filament\Tables\Columns\TextColumn::make('payment_status')->label('Payment Status'),
            \Filament\Tables\Columns\TextColumn::make('created_at')->dateTime(),
            ];
            
    }

    
protected function getTableActions(): array
{
    return [
        Action::make('View Order')
            ->url(fn (Order $record): string => OrderResource::getUrl('view', ['record' => $record]))
            ->color('info'),
    ];
}

    


    

    // Optional: Anzahl der Einträge pro Seite
    protected function getTableRecordsPerPage(): int
    {
        return 5;
    }
}
