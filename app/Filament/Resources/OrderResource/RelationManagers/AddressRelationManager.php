<?php

namespace App\Filament\Resources\OrderResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\AttachAction;

class AddressRelationManager extends RelationManager
{
    protected static string $relationship = 'address';

    protected static ?string $recordTitleAttribute = 'street_address';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('first_name')
                ->required()
                ->maxLength(255),

                TextInput::make('last_name')
                ->required()
                ->maxLength(255),


                TextInput::make('phone')
                ->required()
                ->tel()
                ->maxLength(20),

                TextInput::make('city')
                ->required()
                ->maxLength(255),
                
                TextInput::make('state')
                ->required()
                ->maxLength(255),

                TextInput::make('zip_code')
                ->required()
                ->numeric()
                ->maxLength(10),

                TextInput::make('street_address')
                ->required()
                ->columnSpanFull(),
                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            // ->recordTitleAttribute('street_address')
            ->columns([
                TextColumn::make('fullname')
                ->label('Full Name'),


                TextColumn::make('phone'),

                TextColumn::make('city'),

                TextColumn::make('state'),

                TextColumn::make('zip_code'),

                TextColumn::make('street_address'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }    
}
