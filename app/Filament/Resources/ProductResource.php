<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Category;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Products';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title'),

                FileUpload::make('image')
                        ->disk('public') 
                        ->directory('products')
                        ->multiple()
                        ->maxFiles(10)
                        ->required(),

                Textarea::make('description'),

                TextInput::make('price')
                ->label('Price')
                ->required()
                ->numeric()
                ->minValue(0)
                ->placeholder('Enter price')
                ->hint('Enter a decimal value, e.g., 19.99'),

                Select::make('category_id')
                    ->label('Category')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->required()
                    ->options(function (callable $get) {
                        return Category::orderBy('created_at','desc')->pluck('name', 'id');
                    }),

                Hidden::make('user_id')
                        ->default(Auth::user()->id)

            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->label('Image')
                    ->getStateUsing(function ($record) {
                        $images = json_decode($record->image, true);
                        return $images ? asset('storage/' . $images[0]) : null;
                    })
                    ->disk('public')
                    ->width(50)
                    ->height(50),
                
                TextColumn::make('title'),
                TextColumn::make('price'),
                TextColumn::make('description')->limit(50),
            ])->defaultSort('id', 'desc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
