<?php

namespace App\Filament\Resources\EbookDownloadResource\Pages;

use App\Filament\Resources\EbookDownloadResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEbookDownloads extends ListRecords
{
    protected static string $resource = EbookDownloadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}