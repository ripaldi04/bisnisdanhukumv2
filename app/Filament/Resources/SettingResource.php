<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SettingResource\Pages;
use App\Models\Setting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Get;

class SettingResource extends Resource
{
    protected static ?string $model = Setting::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationLabel = 'Settings';
    protected static ?string $navigationGroup = 'Settings';
    protected static ?int $navigationSort = 999;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('key')
                ->label('Key')
                ->disabled()
                ->dehydrated(false),

            // Kalau key = whatsapp_number => pakai TextInput
            Forms\Components\TextInput::make('value')
                ->label('Nomor WhatsApp')
                ->helperText('Format: 62xxx tanpa + (contoh: 6281234567890)')
                ->visible(fn (Get $get) => $get('key') === 'whatsapp_number')
                ->required(fn (Get $get) => $get('key') === 'whatsapp_number')
                ->maxLength(30),

            // Kalau key = whatsapp_message_template => pakai Textarea
            Forms\Components\Textarea::make('value')
                ->label('Template Pesan WhatsApp')
                ->helperText('Placeholder: {title}, {name}, {email}, {url}')
                ->visible(fn (Get $get) => $get('key') === 'whatsapp_message_template')
                ->required(fn (Get $get) => $get('key') === 'whatsapp_message_template')
                ->rows(10),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('key')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('value')
                    ->limit(60)
                    ->wrap(),
                Tables\Columns\TextColumn::make('updated_at')->dateTime()->sortable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([]); // no bulk
    }

    // Biar resource ini cuma buat edit 2 key itu
    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()
            ->whereIn('key', ['whatsapp_number', 'whatsapp_message_template']);
    }

    // Disable create/delete
    public static function canCreate(): bool { return false; }
    public static function canDeleteAny(): bool { return false; }
    public static function canDelete(\Illuminate\Database\Eloquent\Model $record): bool { return false; }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSetting::route('/'),
            'edit'  => Pages\EditSetting::route('/{record}/edit'),
        ];
    }
}
