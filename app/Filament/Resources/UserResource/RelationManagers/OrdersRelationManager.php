<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use App\Filament\Resources\OrderResource;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use App\Models\Order;

use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\DeleteAction;

class OrdersRelationManager extends RelationManager
{
    protected static string $relationship = 'orders';

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
               
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                ->label('Order ID')
                ->searchable(),


                TextColumn::make('grand_total')
                ->money('EUR'),
               

                BadgeColumn::make('status')
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
                })
            ->sortable(),

            TextColumn::make('payment_method')
            ->sortable()
            ->searchable(),


            TextColumn::make('payment_status')
            ->sortable()
            ->searchable(),


            TextColumn::make('created_at')
            ->label('Order Date')
            ->dateTime(),
            
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Action::make('View Order')
                ->url(fn(Order $record):string => OrderResource::getUrl('view',['record' => $record]))
                ->color('info'),
                // Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }    
}
