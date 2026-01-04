<?php

namespace App\Filament\Resources;

use App\Filament\Imports\EmailRecipientImporter;
use App\Filament\Resources\BroadcastEmailResource\Pages;
use App\Filament\Resources\BroadcastEmailResource\RelationManagers\EmailRecepientsRelationManager;
use App\Models\BroadcastEmail;
use App\Models\EmailRecipient;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ImportAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BroadcastEmailResource extends Resource
{
    protected static ?string $model = BroadcastEmail::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->required()
                    ->label('Judul Pesan'),

                // Select::make('recipients')
                //     ->label('Penerima Email')
                //     ->multiple()
                //     ->preload(50)
                //     ->relationship('emailRecipients', 'email')

                //     ->required(),
                RichEditor::make('content')
                    ->required()
                    ->label('Isi Pesan')
                    ->columnSpan('full'),
                // CheckboxList::make('recipients')
                //     ->label('Penerima Email')
                //     ->relationship('emailRecipients', 'email')
                //     ->searchable()
                //     ->bulkToggleable()
                //     ->columns(8)
                //     ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->headerActions([
                ImportAction::make()
                    ->importer(EmailRecipientImporter::class)
                    ->chunkSize(200000)
                    ->label('Import Email Recipients')
            ])
            ->columns([
                TextColumn::make('title')
                    ->label('Judul Pesan')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label('Dikirim Pada')
                    ->sortable()
                    ->dateTime()
            ])
            ->defaultSort('created_at', 'desc')
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
            EmailRecepientsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBroadcastEmails::route('/'),
            'create' => Pages\CreateBroadcastEmail::route('/create'),
            'edit' => Pages\EditBroadcastEmail::route('/{record}/edit'),
        ];
    }
}
