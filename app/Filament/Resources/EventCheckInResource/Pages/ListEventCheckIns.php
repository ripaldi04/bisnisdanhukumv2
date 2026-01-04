<?php

namespace App\Filament\Resources\EventCheckInResource\Pages;

use App\Filament\Resources\EventCheckInResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEventCheckIns extends ListRecords
{
    protected static string $resource = EventCheckInResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
