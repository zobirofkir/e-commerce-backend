<?php

namespace App\Filament\Resources\CategoryResource\RelationManagers;

use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class ProductsRelationManager extends RelationManager
{
    protected static string $relationship = 'products';

    public function form(Form $form): Form
    {
        return $form
        ->schema([
            TextInput::make('title'),

            FileUpload::make('image')
                    ->disk('public') 
                    ->directory('blogs')
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

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                ImageColumn::make('image')
                ->label('Image')
                ->label('Image')
                ->disk('public') 
                ->width(50) 
                ->height(50),
                
                TextColumn::make('title'),
                TextColumn::make('price'),
                TextColumn::make('description')->limit(50),
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
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
