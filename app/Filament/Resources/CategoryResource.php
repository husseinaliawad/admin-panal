<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Filament\Resources\CategoryResource\RelationManagers;
use App\Models\Category;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\FileUpload;
use Illuminate\Support\Str;
use Filament\Forms\Set;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;
    protected static ?int $navigationSort = 3;

    protected static ?string $navigationIcon = 'heroicon-o-tag';
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
                        ->directory('categories'),
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
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }    
}
