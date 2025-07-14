<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BrandsResource\Pages;
use App\Filament\Resources\BrandsResource\RelationManagers;
use App\Models\Brand;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Illuminate\Support\Str;
use Filament\Forms\Set;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
class BrandsResource extends Resource
{
    protected static ?string $model = Brand::class;
    
    protected static ?string $recordTitleAttribute = 'name';
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationIcon = 'heroicon-o-cube-transparent';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Kategorie-Daten')
                ->schema([
                    Grid::make()
                        ->schema([
                            TextInput::make('name')
                                ->required()
                                ->maxLength(255)
                                ->reactive()
                                ->afterStateUpdated(function ($state, $set) {
                                    $set('slug', \Illuminate\Support\Str::slug($state));
                                }), // <-- Das Komma ist wichtig!
                            TextInput::make('slug')
                                ->required()
                                ->disabled()
                                ->dehydrated()
                                ->maxLength(255)
                                ->unique(ignoreRecord: true),
                        ]),
                    FileUpload::make('image')
                        ->image()
                        ->directory('brands'),
                    Toggle::make('is_active')
                        ->required()
                        ->default(true),
                ]),
                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                ->searchable(),
                ImageColumn::make('image')
                ->searchable(),
                TextColumn::make('slug')
                ->searchable(),
                IconColumn::make('is_active')
                ->boolean(),
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
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
    
    public static function getRelations(): array
    {
        return [
            //
        ];
    }
    
    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'email'];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBrands::route('/'),
            'create' => Pages\CreateBrands::route('/create'),
            'edit' => Pages\EditBrands::route('/{record}/edit'),
        ];
    }    
}
