<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LiveCourseTransactionsResource\Pages;
use App\Filament\Resources\LiveCourseTransactionsResource\RelationManagers;
use App\Models\LiveCourseTransaction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LiveCourseTransactionsResource extends Resource
{
    protected static ?string $model = LiveCourseTransaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Products';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->label('User')
                    ->searchable()
                    ->required(),

                Forms\Components\Select::make('live_course_id')
                    ->relationship('liveCourse', 'title')
                    ->label('Kelas Zoom')
                    ->searchable()
                    ->required(),

                Forms\Components\TextInput::make('trx_id')
                    ->label('Transaction ID')
                    ->required()
                    ->unique(ignoreRecord: true),

                Forms\Components\TextInput::make('amount')
                    ->numeric()
                    ->label('Total Harga')
                    ->required(),

                Forms\Components\Select::make('status')
                    ->options([
                        'Pending' => 'Pending',
                        'Paid' => 'Paid',
                        'Failed' => 'Failed',
                        'Expired' => 'Expired',
                    ])
                    ->required(),

                Forms\Components\TextInput::make('payment_type')
                    ->label('Payment Type')
                    ->nullable(),

                Forms\Components\TextInput::make('midtrans_transaction_id')
                    ->label('Midtrans Transaction ID')
                    ->nullable(),

                Forms\Components\DateTimePicker::make('paid_at')
                    ->label('Paid At')
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('User')
                    ->searchable(),

                Tables\Columns\TextColumn::make('liveCourse.title')
                    ->label('Live Course')
                    ->searchable(),

                Tables\Columns\TextColumn::make('trx_id')
                    ->label('Trx ID')
                    ->searchable(),

                Tables\Columns\TextColumn::make('amount')
                    ->money('IDR')
                    ->sortable(),

                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'secondary' => 'Pending',
                        'success' => 'Paid',
                        'danger' => 'Failed',
                        'warning' => 'Expired',
                    ]),

                Tables\Columns\TextColumn::make('paid_at')
                    ->label('Paid At')
                    ->dateTime(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->label('Created'),
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
            'index' => Pages\ListLiveCourseTransactions::route('/'),
            'create' => Pages\CreateLiveCourseTransactions::route('/create'),
            'edit' => Pages\EditLiveCourseTransactions::route('/{record}/edit'),
        ];
    }
}
