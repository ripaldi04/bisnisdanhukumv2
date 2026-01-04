<?php

namespace App\Filament\Resources\OfflineEventResource\Pages;

use App\Filament\Resources\OfflineEventResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListOfflineEvents extends ListRecords
{
    protected static string $resource = OfflineEventResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
