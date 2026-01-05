<?php

namespace App\Filament\Resources\EbookLandingDescriptionResource\Pages;

use App\Filament\Resources\EbookLandingDescriptionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEbookLandingDescriptions extends ListRecords
{
    protected static string $resource = EbookLandingDescriptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
