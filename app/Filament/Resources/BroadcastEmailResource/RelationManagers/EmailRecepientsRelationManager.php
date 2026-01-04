<?php

namespace App\Filament\Resources\BroadcastEmailResource\RelationManagers;

use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EmailRecepientsRelationManager extends RelationManager
{
    protected static string $relationship = 'emailRecipients';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('Email Recipients')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('Email Recipients')
            ->columns([
                TextColumn::make('email')->label('Email'),

                IconColumn::make('is_registered')
                    ->boolean()
                    ->label('Sudah Terdaftar?')
                    ->getStateUsing(fn($record) => User::where('email', $record->email)->exists()),

                IconColumn::make('is_membership')
                    ->boolean()
                    ->label('Sudah Membership?')
                    ->getStateUsing(fn($record) => User::where('email', $record->email)
                        ->whereHas(
                            'subscribe_transactions',
                            fn($query) =>
                            $query->where('status', 'Success')
                                ->whereDate('subscription_start_date', '>=', now()->subYear())
                        )->exists()),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ]);
    }
}
