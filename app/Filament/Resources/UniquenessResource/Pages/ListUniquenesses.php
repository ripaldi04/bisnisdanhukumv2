<?php

namespace App\Filament\Resources\UniquenessResource\Pages;

use App\Filament\Resources\UniquenessResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUniquenesses extends ListRecords
{
    protected static string $resource = UniquenessResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
