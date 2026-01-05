<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EbookLandingDescriptionResource\Pages;
use App\Filament\Resources\EbookLandingDescriptionResource\RelationManagers;
use App\Models\Ebook;
use App\Models\EbookLandingDescription;
use Filament\Forms;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EbookLandingDescriptionResource extends Resource
{
    protected static ?string $model = EbookLandingDescription::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'Ebook Landing Descriptions';

    protected static ?string $navigationGroup = 'Content Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('ebook_id')
                    ->label('Ebook')
                    ->options(Ebook::pluck('title', 'id'))
                    ->required(),
                RichEditor::make('description')
                    ->label('Description')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('ebook.title')
                    ->label('Ebook'),
                TextColumn::make('description')
                    ->limit(50),
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
            'index' => Pages\ListEbookLandingDescriptions::route('/'),
            'create' => Pages\CreateEbookLandingDescription::route('/create'),
            'edit' => Pages\EditEbookLandingDescription::route('/{record}/edit'),
        ];
    }
}
