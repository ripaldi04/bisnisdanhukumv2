<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CourseResource\Pages;
use App\Filament\Resources\CourseResource\RelationManagers;
use App\Models\Course;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CourseResource extends Resource
{
    protected static ?string $model = Course::class;

    protected static ?string $navigationIcon = 'heroicon-o-information-circle';

    protected static ?string $navigationGroup = 'Site Information';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->required(),
                TextInput::make('phone')
                    ->required()
                    ->integer()
                    ->helperText('Example: 62831512321'),
                Textarea::make('description')
                    ->required()
                    ->autosize()
                    ->columnSpanFull(),
                Textarea::make('banner_main_text')
                    ->required()
                    ->autosize()
                    ->label('Main Text Banner'),
                Textarea::make('banner_text')
                    ->required()
                    ->autosize()
                    ->label('Text Banner'),
                TextInput::make('trailer')
                    ->required()
                    ->label('Link Video Youtube Trailer')
                    ->helperText('Contoh: Jika linknya https://youtu.be/HEsMKIYW4lI maka yang diinput adalah HEsMKIYW4lI'),
                Textarea::make('address')
                    ->required()
                    ->autosize(),
                FileUpload::make('logo')
                    ->image()
                    ->imageEditor()
                    ->directory('logos'),
                FileUpload::make('favicon')
                    ->image()
                    ->imageEditor()
                    ->directory('favicon'),
                FileUpload::make('illustration')
                    ->image()
                    ->imageEditor()
                    ->directory('illustration'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('logo'),
                TextColumn::make('title')
                    ->description(fn(Course $record): string => $record->description)
                    ->wrap()
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
            'index' => Pages\ListCourses::route('/'),
            'create' => Pages\CreateCourse::route('/create'),
            'edit' => Pages\EditCourse::route('/{record}/edit'),
        ];
    }
}
