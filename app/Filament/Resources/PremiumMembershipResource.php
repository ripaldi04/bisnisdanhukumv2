<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PremiumMembershipResource\Pages;
use App\Filament\Resources\PremiumMembershipResource\RelationManagers;
use App\Models\PremiumMembership;
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

class PremiumMembershipResource extends Resource
{
    protected static ?string $model = PremiumMembership::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Site Information';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Textarea::make('title')
                    ->required()
                    ->autosize(),
                Textarea::make('sub_title')
                    ->required()
                    ->autosize(),
                Textarea::make('description')
                    ->required()
                    ->autosize(),
                TextInput::make('price')
                    ->required()
                    ->integer()
                    ->prefix('IDR'),
                Repeater::make('premiumDescriptions')
                    ->relationship()
                    ->schema([
                        TextInput::make('content')->required()->label('Benefit')
                    ])
                    ->label('Benfit Items')
                    ->addActionLabel('Add Benefit')
                    ->columnSpan('full')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->description(fn(PremiumMembership $record): string => $record->sub_title)
                    ->wrap(),
                TextColumn::make('price')
                    ->money('IDR')
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
            'index' => Pages\ListPremiumMemberships::route('/'),
            'create' => Pages\CreatePremiumMembership::route('/create'),
            'edit' => Pages\EditPremiumMembership::route('/{record}/edit'),
        ];
    }
}
