<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OfflineEventResource\Pages;
use App\Filament\Resources\OfflineEventResource\RelationManagers;
use App\Models\OfflineEvent;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OfflineEventResource extends Resource
{
    protected static ?string $model = OfflineEvent::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Products';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Acara')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Judul Acara')
                            ->required()
                            ->live(onBlur: true),

                        Forms\Components\Textarea::make('description')
                            ->label('Deskripsi')
                            ->rows(4)
                            ->nullable(),
                    ]),

                Forms\Components\Section::make('Lokasi')
                    ->schema([
                        Forms\Components\TextInput::make('location')
                            ->label('Tempat')
                            ->required(),

                        Forms\Components\Textarea::make('address')
                            ->label('Alamat Lengkap')
                            ->rows(3)
                            ->nullable(),
                    ]),

                Forms\Components\Section::make('Waktu Acara')
                    ->schema([
                        Forms\Components\DateTimePicker::make('start_time')
                            ->label('Mulai')
                            ->required(),

                        Forms\Components\DateTimePicker::make('end_time')
                            ->label('Selesai')
                            ->nullable(),
                    ]),

                Forms\Components\Section::make('Detail Tiket')
                    ->schema([
                        Forms\Components\TextInput::make('price')
                            ->label('Harga Tiket')
                            ->numeric()
                            ->default(0),

                        Forms\Components\Toggle::make('is_free')
                            ->label('Gratis?'),

                        Forms\Components\TextInput::make('capacity')
                            ->numeric()
                            ->nullable()
                            ->label('Kapasitas'),
                    ]),

                Forms\Components\Section::make('Media & Status')
                    ->schema([
                        Forms\Components\FileUpload::make('banner')
                            ->directory('events/banners')
                            ->image()
                            ->nullable()
                            ->label('Banner'),

                        Forms\Components\Select::make('status')
                            ->options([
                                'draft' => 'Draft',
                                'published' => 'Published',
                                'closed' => 'Closed',
                            ])
                            ->default('draft')
                            ->required(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('banner')
                    ->label('Banner')
                    ->size(50),

                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('location')
                    ->label('Lokasi'),

                Tables\Columns\TextColumn::make('start_time')
                    ->label('Mulai')
                    ->dateTime(),

                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'draft',
                        'success' => 'published',
                        'danger' => 'closed',
                    ])
                    ->label('Status'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListOfflineEvents::route('/'),
            'create' => Pages\CreateOfflineEvent::route('/create'),
            'edit' => Pages\EditOfflineEvent::route('/{record}/edit'),
        ];
    }
}
