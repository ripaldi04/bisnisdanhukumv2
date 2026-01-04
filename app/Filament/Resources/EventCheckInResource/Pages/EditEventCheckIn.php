<?php

namespace App\Filament\Resources\EventCheckInResource\Pages;

use App\Filament\Resources\EventCheckInResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEventCheckIn extends EditRecord
{
    protected static string $resource = EventCheckInResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\DeleteAction::make(),
        ];
    }
}
