<?php

namespace App\Filament\Resources\OfflineEventTransactionResource\Pages;

use App\Filament\Resources\OfflineEventTransactionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOfflineEventTransaction extends EditRecord
{
    protected static string $resource = OfflineEventTransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\DeleteAction::make(),
        ];
    }
}
