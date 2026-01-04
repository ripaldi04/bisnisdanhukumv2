<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ToDoListResource\Pages;
use App\Filament\Resources\ToDoListResource\RelationManagers;
use App\Models\TodoList;
use Filament\Forms;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ToDoListResource extends Resource
{
    protected static ?string $model = ToDoList::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';

    protected static ?string $navigationGroup = 'Contents';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')->required()->columnSpan('full'),
                Textarea::make('description')->columnSpan('full'),
                Repeater::make('todoChecklistItems')
                    ->relationship()
                    ->schema([
                        TextInput::make('title')->required()->label('Item')
                    ])
                    ->label('Checklist Items')
                    ->addActionLabel('Add Checklist Item')
                    ->columnSpan('full')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title'),
                TextColumn::make('description')
            ])
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
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListToDoLists::route('/'),
            'create' => Pages\CreateToDoList::route('/create'),
            'edit' => Pages\EditToDoList::route('/{record}/edit'),
        ];
    }
}
