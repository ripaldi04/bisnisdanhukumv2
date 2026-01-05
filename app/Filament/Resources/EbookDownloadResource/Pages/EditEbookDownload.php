<?php

namespace App\Filament\Resources\EbookDownloadResource\Pages;

use App\Filament\Resources\EbookDownloadResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEbookDownload extends EditRecord
{
    protected static string $resource = EbookDownloadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}