<?php

namespace App\Filament\Resources\EbookTransactionResource\Pages;

use App\Filament\Resources\EbookTransactionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEbookTransaction extends EditRecord
{
    protected static string $resource = EbookTransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\DeleteAction::make(),
        ];
    }
}
