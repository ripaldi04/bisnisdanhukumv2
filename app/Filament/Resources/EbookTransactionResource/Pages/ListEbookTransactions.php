<?php

namespace App\Filament\Resources\EbookTransactionResource\Pages;

use App\Filament\Resources\EbookTransactionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEbookTransactions extends ListRecords
{
    protected static string $resource = EbookTransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
