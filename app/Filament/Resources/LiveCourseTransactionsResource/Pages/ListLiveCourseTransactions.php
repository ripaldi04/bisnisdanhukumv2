<?php

namespace App\Filament\Resources\LiveCourseTransactionsResource\Pages;

use App\Filament\Resources\LiveCourseTransactionsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLiveCourseTransactions extends ListRecords
{
    protected static string $resource = LiveCourseTransactionsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
