<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LiveCourseResource\Pages;
use App\Filament\Resources\LiveCourseResource\RelationManagers;
use App\Models\LiveCourse;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LiveCourseResource extends Resource
{
    protected static ?string $model = LiveCourse::class;

    protected static ?string $navigationIcon = 'heroicon-o-question-mark-circle';

    protected static ?string $navigationGroup = 'Products';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Kelas')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Judul Kelas')
                            ->required(),

                        Forms\Components\Textarea::make('description')
                            ->label('Deskripsi')
                            ->rows(4),

                        Forms\Components\FileUpload::make('cover_image')
                            ->label('Gambar Cover')
                            ->image()
                            ->disk('public')
                            ->directory('live-courses')
                            ->nullable()
                            ->helperText('Upload gambar cover untuk kelas (Opsional)'),

                        Forms\Components\DateTimePicker::make('start_time')
                            ->label('Mulai')
                            ->required(),

                        Forms\Components\DateTimePicker::make('end_time')
                            ->label('Selesai'),
                    ]),

                Forms\Components\Section::make('Zoom Details')
                    ->schema([
                        Forms\Components\TextInput::make('zoom_link')
                            ->label('Zoom Link')
                            ->url()
                            ->nullable(),

                        Forms\Components\TextInput::make('meeting_id')
                            ->label('Meeting ID')
                            ->nullable(),

                        Forms\Components\TextInput::make('meeting_password')
                            ->label('Meeting Password')
                            ->nullable(),
                    ])->collapsed(),

                Forms\Components\Section::make('Pricing')
                    ->schema([
                        Forms\Components\TextInput::make('price')
                            ->numeric()
                            ->label('Harga')
                            ->default(0),

                        Forms\Components\Toggle::make('is_free')
                            ->label('Gratis?'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('cover_image')
                    ->label('Cover')
                    ->disk('public')
                    ->size(60),

                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('start_time')
                    ->label('Mulai')
                    ->dateTime()
                    ->sortable(),

                Tables\Columns\TextColumn::make('price')
                    ->money('IDR')
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_free')
                    ->boolean()
                    ->label('Gratis?'),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->label('Dibuat'),
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
            'index' => Pages\ListLiveCourses::route('/'),
            'create' => Pages\CreateLiveCourse::route('/create'),
            'edit' => Pages\EditLiveCourse::route('/{record}/edit'),
        ];
    }
}
