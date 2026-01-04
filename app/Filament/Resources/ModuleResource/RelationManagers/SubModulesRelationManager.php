<?php

namespace App\Filament\Resources\ModuleResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SubModulesRelationManager extends RelationManager
{
    protected static string $relationship = 'subModules';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                TextInput::make('order')
                    ->required()
                    ->integer(),
                Textarea::make('description')
                    ->columnSpan('full'),
                Select::make('type')
                    ->columnSpan('full')
                    ->options([
                        'text' => 'Text',
                        'video' => 'Video',
                        'document' => 'Document',
                        'audio' => 'Audio',
                    ])
                    ->live()
                    ->afterStateUpdated(fn(Select $component) => $component
                        ->getContainer()
                        ->getComponent('dynamicTypeFields')
                        ->getChildComponentContainer()
                        ->fill()),
                Grid::make()
                    ->schema(fn(Get $get): array => match ($get('type')) {
                        'video' => [
                            TextInput::make('content')
                                ->required()
                                ->columnSpan('full')
                                ->label('Path Video Youtube')
                                ->helperText('Contoh: Jika linknya https://youtu.be/HEsMKIYW4lI maka yang diinput adalah HEsMKIYW4lI')
                        ],
                        'document' => [
                            FileUpload::make('content')
                                ->required()
                                ->columnSpan('full')
                                ->label('Document')
                                ->directory('documents'),
                        ],
                        'audio' => [
                            FileUpload::make('content')
                                ->required()
                                ->columnSpan('full')
                                ->label('Audio')
                                ->directory('audios'),
                        ],
                        'text' => [
                            RichEditor::make('content')
                                ->required()->columnSpan('full')->label('Text'),
                        ],
                        default => [],
                    })
                    ->key('dynamicTypeFields'),
                DateTimePicker::make('published_date')->required()->columnSpan('full')->label('Published Date'),
                Toggle::make('is_free')
                    ->label('Free')
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                TextColumn::make('order')->sortable(),
                TextColumn::make('title'),
                TextColumn::make('type'),
                TextColumn::make('published_date')->label('Published Date')->dateTime(),
                IconColumn::make('is_free')
                ->boolean()
                ->label('Free?')
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
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
}
