<?php

namespace App\Filament\Resources;
use Filament\Tables\Columns\SelectColumn;
use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Filament\Resources\OrderResource\RelationManagers\AddressRelationManager;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Components\Concerns\CanDisableOptions;
use Filament\Forms\Components\Placeholder;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Radio;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Repeater;
use App\Models\OrderItem;
use App\Models\Product;
use Filament\Forms\Set;
use Filament\Forms\Get;
use NumberFormatter; // falls du NumberFormatter nutzen möchtest
use App\Filament\Resources\Number;
use Filament\Forms\Components\Hidden;


class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?int $navigationSort = 5;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                    Group::make()->schema([
                        Section::make('Order Information')->schema([
                            Select::make('user_id')
                                ->label('Customer')
                                ->relationship('user', 'name')
                                ->searchable()
                                ->preload()
                                ->required(),
                
                            Select::make('payment_method')
                                ->options([
                                    'stripe' => 'Stripe',
                                    'paypal' => 'Paypal'
                                ])
                                ->required(),
                
                            Select::make('payment_status')
                                ->options([
                                    'pending' => 'Pending',
                                    'paid' => 'Paid',
                                    'failed' => 'Failed'
                                ])
                                ->default('pending')
                                ->required(),
                
                            Radio::make('status')
                                ->inline()
                                ->default('new')
                                ->required()
                                ->options([
                                    'new' => 'New',
                                    'processing' => 'Processing',
                                    'shipped' => 'Shipped',
                                    'delivered' => 'Delivered',
                                    'cancelled' => 'Cancelled',
                                ]),
                
                            Select::make('shipping_method')
                                ->options([
                                    'dhl' => 'DHL',
                                    'ups' => 'UPS'
                                ]),
                
                            Textarea::make('notes')
                                ->columnSpanFull(),
                        ])->columns(2),
                
                        Section::make('Order Items')->schema([
                              
                            Repeater::make('items')
                            ->relationship()
                            ->schema([
                                Select::make('product_id')
                                    ->relationship('product', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->columnSpan(4)
                                    ->reactive()
                                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                        $price = Product::find($state)?->price ?? 0;
                                        $set('unit_amount', $price);
                                        $quantity = $get('quantity') ?? 1;
                                        $set('total_amount', $price * $quantity);
                                    }),

                                TextInput::make('quantity')
                                    ->numeric()
                                    ->required()
                                    ->default(1)
                                    ->minValue(1)
                                    ->columnSpan(2)
                                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                        $unitAmount = $get('unit_amount') ?? 0;
                                        $set('total_amount', $state * $unitAmount);
                                    }),

                                    TextInput::make('unit_amount')
                                    ->numeric()
                                    ->required()
                                    // ->disabled() // NICHT verwenden!
                                    // ->readOnly() // Gibt es nicht in v2!
                                    ->columnSpan(3),
    

        
                                        TextInput::make('total_amount')
                                            ->numeric()
                                            ->required()
                                            // ->disabled() // NICHT verwenden!
                                            // ->readOnly() // Gibt es nicht in v2!
                                            ->columnSpan(3),
                                        
                                    ])->columns(12),

                                // Placeholder für Grand Total außerhalb des Repeaters
                                Placeholder::make('grand_total_placeholder')
                                    ->label('Grand Total')
                                    ->content(function (callable $get, callable $set)
                                       {  $total=0;
                                        if(!$repeaters = $get('items')){
                                            return $total;
                                        }

                                        foreach($repeaters as $key => $repeater){
                                            $total += $get("items.{$key}.total_amount");
                                        }

                                        $set('grand_total',$total);
                                        return number_format($total, 2) . ' €';
                                
                                    }),

                                    Hidden::make('grand_total')
                                    ->default(0),
                                    ])
                                ])->columnSpanFull()
                ]);
                
               
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                ->label('Customer')
                ->sortable()
                ->searchable(),

                TextColumn::make('grand_total')
                ->sortable()
                ->money('EUR'),

                TextColumn::make('payment_method')
                ->sortable()
                ->searchable(),

                TextColumn::make('payment_status')
                ->sortable()
                ->searchable(),

                // TextColumn::make('currency')
                // ->sortable()
                // ->searchable(),

                TextColumn::make('shipping_method')
                ->sortable()
                ->searchable(),



                SelectColumn::make('status')
                ->options([
                    'new' => 'New',
                                    'processing' => 'Processing',
                                    'shipped' => 'Shipped',
                                    'delivered' => 'Delivered',
                                    'cancelled' => 'Cancelled',

                ])
                ->searchable()
                ->sortable(),
              

                TextColumn::make('created_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault:true),
                TextColumn::make('updated_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault:true),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
    
    public static function getRelations(): array
    {
        return [
            AddressRelationManager::class
        ];
    }

    public static function getWidgets(): array
{
    return [
        \App\Filament\Resources\OrderResource\Widgets\OrderStats::class,
    ];
}

    
    // public static function getNavigationBadge():?string{
    //     return static::getModel()::count();
    // } 

    // public static function getNavigationBadgeColor():?string{
    //     return static::getModel()::count() > 10 ? 'success' : 'danger';
    // } 
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'view' => Pages\ViewOrder::route('/{record}'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }    
}
