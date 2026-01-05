<?php

namespace App\Filament\Resources\EbookDownloadResource\Pages;

use App\Filament\Resources\EbookDownloadResource;
use App\Models\EbookDownload;
use App\Models\EmailRecipient;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;

class ListEbookDownloads extends ListRecords
{
    protected static string $resource = EbookDownloadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\Action::make('importEmailsToRecipients')
                ->label('Import Emails to Broadcast Recipients')
                ->icon('heroicon-o-user-group')
                ->color('success')
                ->action(function () {
                    $emails = EbookDownload::distinct()->pluck('email')->toArray();

                    if (empty($emails)) {
                        Notification::make()
                            ->title('No emails found')
                            ->body('There are no ebook download emails to import.')
                            ->warning()
                            ->send();
                        return;
                    }

                    $imported = 0;
                    foreach ($emails as $email) {
                        EmailRecipient::firstOrCreate(['email' => $email]);
                        $imported++;
                    }

                    Notification::make()
                        ->title('Emails imported successfully')
                        ->body("Imported {$imported} unique emails to broadcast recipients.")
                        ->success()
                        ->send();
                }),
        ];
    }
}