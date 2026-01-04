<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OfflineEventTransactionResource\Pages;
use App\Filament\Resources\OfflineEventTransactionResource\RelationManagers;
use App\Models\OfflineEventTransaction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OfflineEventTransactionResource extends Resource
{
    protected static ?string $model = OfflineEventTransaction::class;

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
                    ->label('User'),

                Tables\Columns\TextColumn::make('event.title')
                    ->label('Event'),

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
                        'secondary' => 'Expired',
                    ])
                    ->label('Status'),

                Tables\Columns\TextColumn::make('ticket_code')
                    ->label('Ticket Code'),

                Tables\Columns\TextColumn::make('paid_at')
                    ->label('Paid at')
                    ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListOfflineEventTransactions::route('/'),
            'create' => Pages\CreateOfflineEventTransaction::route('/create'),
            'edit' => Pages\EditOfflineEventTransaction::route('/{record}/edit'),
        ];
    }
}
