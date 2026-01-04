<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Filament\Resources\UserResource\RelationManagers\UserProgressesRelationManager;
use App\Filament\Resources\UserResource\RelationManagers\UserTodoProgressesRelationManager;
use App\Models\User;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name'),
                TextInput::make('email'),
                TextInput::make('sosial_media')
                    ->label('Kota / Kabupaten'),
                TextInput::make('no_hp')
                    ->label('No HP'),
                TextInput::make('referral_commission_percentage')
                    ->integer()
                    ->minValue(1)
                    ->maxValue(100)
                    ->label('Persentase Komisi Referral (%)')
                    ->helperText('Isi dengan persentase komisi (tanpa desimal, contoh: 10 untuk 10%)')
                    ->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('email')
                    ->searchable(),
                TextColumn::make('no_hp')
                    ->label('Phone')
                    ->searchable(),
                IconColumn::make('is_membership')
                    ->label('Status Membership')
                    ->boolean()
                    ->getStateUsing(function ($record) {
                        return $record->hasActiveSubscription();
                    }),

                // Column for membership expiration date
                TextColumn::make('membership_expiration')
                    ->label('Tanggal Berakhir Membership')
                    ->getStateUsing(function (User $record): ?string {
                        $latestSubscription = $record->subscribe_transactions()
                            ->where('status', 'Success')
                            ->latest('updated_at')
                            ->first();

                        if (!$latestSubscription) {
                            return null; // No active subscription
                        }

                        $subscriptionEndDate = Carbon::parse($latestSubscription->subscription_start_date)->addYear(1);
                        return $subscriptionEndDate->format('Y-m-d'); // Format date as needed
                    })
                    ->date(),
            ])
            ->filters([
                Filter::make('Membership')
                    ->query(function (Builder $query, array $data) {
                        if ($data['status'] === 'with') {
                            return $query->whereHas('subscribe_transactions', function ($q) {
                                $q->where('status', 'Success')
                                    ->whereDate('subscription_start_date', '>=', now()->subYear());
                            });
                        }

                        if ($data['status'] === 'without') {
                            return $query->whereDoesntHave('subscribe_transactions', function ($q) {
                                $q->where('status', 'Success')
                                    ->whereDate('subscription_start_date', '>=', now()->subYear());
                            });
                        }

                        return $query;
                    })
                    ->form([
                        Select::make('status')
                            ->options([
                                'with' => 'With Membership',
                                'without' => 'Without Membership',
                            ])
                            ->placeholder('Select status')
                            ->label('Filter by Membership'),
                    ]),
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
            UserProgressesRelationManager::class,
            UserTodoProgressesRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
