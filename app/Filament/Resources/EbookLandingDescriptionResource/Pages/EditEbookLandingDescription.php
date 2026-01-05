<?php

namespace App\Filament\Resources\EbookLandingDescriptionResource\Pages;

use App\Filament\Resources\EbookLandingDescriptionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEbookLandingDescription extends EditRecord
{
    protected static string $resource = EbookLandingDescriptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
