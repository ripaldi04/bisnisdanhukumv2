<?php

namespace App\Filament\Resources;

use App\Filament\Imports\EmailRecipientImporter;
use App\Filament\Resources\BroadcastEmailResource\Pages;
use App\Filament\Resources\BroadcastEmailResource\RelationManagers\EmailRecepientsRelationManager;
use App\Mail\BroadcastEmailMailable;
use App\Models\BroadcastEmail;
use App\Models\EmailRecipient;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ImportAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Mail;

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

                RichEditor::make('content')
                    ->required()
                    ->label('Isi Pesan')
                    ->columnSpan('full'),

                Forms\Components\FileUpload::make('file_path')
                    ->label('Lampirkan File (Opsional)')
                    ->directory('broadcast_attachments')
                    ->preserveFilenames()
                    ->acceptedFileTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'])
                    ->maxSize(10240) // 10MB
                    ->columnSpan('full'),
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
                Tables\Actions\Action::make('send')
                    ->label('Kirim')
                    ->icon('heroicon-o-paper-airplane')
                    ->color('success')
                    ->action(function (BroadcastEmail $record) {
                        $broadcastEmail = BroadcastEmail::with('emailRecipients')->find($record->id);
                        $recipients = $broadcastEmail->emailRecipients->pluck('email');

                        if ($recipients->isEmpty()) {
                            Notification::make()
                                ->title('Tidak ada penerima')
                                ->body('Broadcast ini belum memiliki penerima email.')
                                ->warning()
                                ->send();
                            return;
                        }

                        foreach ($recipients as $email) {
                            Mail::to($email)->queue(
                                new BroadcastEmailMailable($broadcastEmail->title, $broadcastEmail->content, $broadcastEmail->file_path)
                            );
                        }

                        Notification::make()
                            ->title('Broadcast dikirim')
                            ->body('Email broadcast telah dikirim ke ' . $recipients->count() . ' penerima.')
                            ->success()
                            ->send();
                    })
                    ->requiresConfirmation()
                    ->modalHeading('Kirim Broadcast Email')
                    ->modalDescription('Apakah Anda yakin ingin mengirim broadcast email ini ke semua penerima?')
                    ->modalSubmitActionLabel('Ya, Kirim'),
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
