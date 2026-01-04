<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EbookTransactionResource\Pages;
use App\Filament\Resources\EbookTransactionResource\RelationManagers;
use App\Models\EbookTransaction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EbookTransactionResource extends Resource
{
    protected static ?string $model = EbookTransaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Products';

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
                Tables\Columns\TextColumn::make('user.name')
                    ->label('User')
                    ->searchable(),

                Tables\Columns\TextColumn::make('ebook.title')
                    ->label('Ebook')
                    ->searchable(),

                Tables\Columns\TextColumn::make('trx_id')
                    ->label('Trx ID')
                    ->searchable(),

                Tables\Columns\TextColumn::make('amount')
                    ->money('IDR')
                    ->label('Amount'),

                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'Pending',
                        'success' => 'Paid',
                        'danger' => 'Failed',
                    ])
                    ->label('Status'),

                Tables\Columns\TextColumn::make('paid_at')
                    ->label('Paid At')
                    ->dateTime(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
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
            'index' => Pages\ListEbookTransactions::route('/'),
            'create' => Pages\CreateEbookTransaction::route('/create'),
            'edit' => Pages\EditEbookTransaction::route('/{record}/edit'),
        ];
    }
}
