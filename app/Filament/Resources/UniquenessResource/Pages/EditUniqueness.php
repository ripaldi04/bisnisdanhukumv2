<?php

namespace App\Filament\Resources\UniquenessResource\Pages;

use App\Filament\Resources\UniquenessResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUniqueness extends EditRecord
{
    protected static string $resource = UniquenessResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
