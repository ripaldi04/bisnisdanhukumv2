<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UniquenessResource\Pages;
use App\Filament\Resources\UniquenessResource\RelationManagers;
use App\Models\Uniqueness;
use Filament\Forms;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UniquenessResource extends Resource
{
    protected static ?string $model = Uniqueness::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Site Information';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                Textarea::make('description')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                Toggle::make('is_active')
                    ->label('Active?')
                    ->onIcon('heroicon-m-bolt')
                    ->offIcon('heroicon-m-user')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->description(fn(Uniqueness $record): string => $record->description)
                    ->wrap(),
                IconColumn::make('is_active')
                    ->boolean()
                    ->label('Active?')
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
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUniquenesses::route('/'),
            'create' => Pages\CreateUniqueness::route('/create'),
            'edit' => Pages\EditUniqueness::route('/{record}/edit'),
        ];
    }
}
