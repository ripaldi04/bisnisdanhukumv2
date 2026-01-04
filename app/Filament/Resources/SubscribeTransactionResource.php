<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SubscribeTransactionResource\Pages;
use App\Filament\Resources\SubscribeTransactionResource\RelationManagers;
use App\Models\SubscribeTransaction;
use Filament\Forms;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SubscribeTransactionResource extends Resource
{
    protected static ?string $model = SubscribeTransaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    protected static ?string $modelLabel = 'Transactions';

    protected static ?string $navigationBadgeTooltip = 'Total Pending Transactions';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'Pending')->count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('total_amount')
                    ->required()
                    ->label('Harga')
                    ->integer()
                    ->suffix('IDR'),
                DateTimePicker::make('created_at')
                    ->label('Waktu Checkout'),
                FileUpload::make('proof')
                    ->label('Bukti Pembayaran')
                    ->image()
                    ->directory('proof')
                    ->imageEditor()
                    ->columnSpan('full'),
                DatePicker::make('subscription_start_date')
                    ->label('Subscription Start Date'),
                Select::make('status')
                    ->options([
                        'Pending' => 'Pending',
                        'Success' => 'Success',
                        'Rejected' => 'Rejected',
                        'Expired' => 'Expired',
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('trx_id')
                    ->searchable()
                    ->label('TRX ID'),
                TextColumn::make('total_amount')
                    ->label('Harga')
                    ->money('IDR'),
                TextColumn::make('user.name'),
                TextColumn::make('created_at')
                    ->label('Waktu Checkout')
                    ->dateTime(),
                IconColumn::make('proof')
                    ->label('Sudah Bayar?')
                    ->boolean() // This automatically displays a checkmark for true and a cross for false
                    ->color(fn($state) => $state ? 'success' : 'danger')
                    ->getStateUsing(fn($record) => !empty($record->proof)),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'Pending' => 'warning',
                        'Success' => 'success',
                        'Rejected' => 'danger',
                        'Expired' => 'danger',
                    })
                    ->label('Status Pembayaran')
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->label('Status Pembayaran')
                    ->options([
                        'Success' => 'Success',
                        'Pending' => 'Pending',
                        'Rejected' => 'Rejected',
                        'Expired' => 'Expired',
                    ])
                    ->default(null)
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
            'index' => Pages\ListSubscribeTransactions::route('/'),
            'create' => Pages\CreateSubscribeTransaction::route('/create'),
            'edit' => Pages\EditSubscribeTransaction::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
