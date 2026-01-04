<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReferralCommissionResource\Pages;
use App\Filament\Resources\ReferralCommissionResource\RelationManagers;
use App\Models\ReferralCommission;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ReferralCommissionResource extends Resource
{
    protected static ?string $model = ReferralCommission::class;

    protected static ?string $navigationIcon = 'heroicon-o-gift';

    protected static ?string $navigationBadgeTooltip = 'Total Pending Pengajuan Komisi Referral';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'Pending')->count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make([
                    TextInput::make('nama_bank')
                        ->readOnly()
                        ->columnSpan(1),
                    TextInput::make('nama_rekening')
                        ->readOnly()
                        ->columnSpan(1),
                    TextInput::make('nomor_rekening')
                        ->readOnly()
                        ->columnSpan(1),
                ])->columns(3)->columnSpanFull(),
                TextInput::make('amount')
                    ->required()
                    ->label('Harga')
                    ->integer()
                    ->suffix('IDR'),
                Select::make('status')
                    ->options([
                        'Not Submitted' => 'Not Submitted',
                        'Pending' => 'Pending',
                        'Success' => 'Success',
                        'Rejected' => 'Rejected',
                    ])
                    ->label('Status Pengajuan'),
                FileUpload::make('proof')
                    ->directory('proof-commission')
                    ->image()
                    ->imageEditor()
                    ->label('Upload Bukti Pembayaran')
                    ->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('referrer.name'),
                TextColumn::make('referredUser.name'),
                TextColumn::make('amount')
                    ->money('IDR'),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'Not Submitted' => 'gray',
                        'Pending' => 'warning',
                        'Success' => 'success',
                        'Rejected' => 'danger',
                    })
                    ->label('Status Pengajuan')
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
            'index' => Pages\ListReferralCommissions::route('/'),
            'create' => Pages\CreateReferralCommission::route('/create'),
            'edit' => Pages\EditReferralCommission::route('/{record}/edit'),
        ];
    }
}
