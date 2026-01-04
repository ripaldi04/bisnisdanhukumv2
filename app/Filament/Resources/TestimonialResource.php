<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TestimonialResource\Pages;
use App\Filament\Resources\TestimonialResource\RelationManagers;
use App\Models\Testimonial;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TestimonialResource extends Resource
{
    protected static ?string $model = Testimonial::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-oval-left-ellipsis';

    protected static ?string $navigationGroup = 'Site Information';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required(),
                TextInput::make('occupation')
                    ->required(),
                Select::make('type')
                    ->columnSpan('full')
                    ->options([
                        'Text' => 'Text',
                        'Video' => 'Video',
                    ])
                    ->live()
                    ->afterStateUpdated(fn(Select $component) => $component
                        ->getContainer()
                        ->getComponent('dynamicTypeFields')
                        ->getChildComponentContainer()
                        ->fill()),
                Grid::make()
                    ->schema(fn(Get $get): array => match ($get('type')) {
                        'Text' => [
                            Textarea::make('content')
                                ->required()
                                ->columnSpan('full')
                                ->label('Content Testimonial')
                                ->autosize(),
                        ],
                        'Video' => [
                            FileUpload::make('content')
                                ->required()
                                ->acceptedFileTypes(['video/mp4'])
                                ->columnSpan('full')
                                ->label('File Video')
                                ->directory('videos'),
                        ],
                        default => [],
                    })
                    ->key('dynamicTypeFields'),
                Toggle::make('is_active')
                    ->label('Active?')
                    ->onIcon('heroicon-m-bolt')
                    ->offIcon('heroicon-m-user'),
                FileUpload::make('avatar')
                    ->image()
                    ->directory('avatar')
                    ->columnSpan('full')
                    ->helperText('Upload gambar dengan ukuran 100 x 100')

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('occupation'),
                TextColumn::make('type'),
                IconColumn::make('is_active')
                    ->boolean()
                    ->label('Active?')
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
            'index' => Pages\ListTestimonials::route('/'),
            'create' => Pages\CreateTestimonial::route('/create'),
            'edit' => Pages\EditTestimonial::route('/{record}/edit'),
        ];
    }
}
