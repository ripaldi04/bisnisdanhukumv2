<?php

namespace App\Filament\Resources\BroadcastEmailResource\Pages;

use App\Filament\Resources\BroadcastEmailResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBroadcastEmail extends EditRecord
{
    protected static string $resource = BroadcastEmailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
