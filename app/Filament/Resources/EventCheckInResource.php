<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventCheckInResource\Pages;
use App\Filament\Resources\EventCheckInResource\RelationManagers;
use App\Models\EventCheckIn;
use App\Models\OfflineEventTransaction;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EventCheckInResource extends Resource
{
    protected static ?string $model = OfflineEventTransaction::class;

    protected static ?string $navigationLabel = 'Check-In Hari H';
    protected static ?string $navigationIcon = 'heroicon-o-qr-code';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        $today = Carbon::today()->toDateString();

        return $table
            ->query(
                OfflineEventTransaction::query()
                    ->whereDate('checked_in_at', $today)
            )
            ->columns([
                TextColumn::make('user.name')
                    ->label('Nama Peserta')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('event.title')
                    ->label('Event')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('checked_in_at')
                    ->label('Waktu Check-In')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
                TextColumn::make('status_checkin')
                    ->label('Status')
                    ->badge()
                    ->getStateUsing(fn($record) => $record->checked_in_at ? 'Sudah Check-In' : 'Belum Check-In')
                    ->colors([
                        'success' => 'Sudah Check-In',
                        'danger' => 'Belum Check-In',
                    ]),

            ])
            ->defaultSort('checked_in_at', 'desc')
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
            'index' => Pages\ListEventCheckIns::route('/'),
            'create' => Pages\CreateEventCheckIn::route('/create'),
            'edit' => Pages\EditEventCheckIn::route('/{record}/edit'),
        ];
    }
}
