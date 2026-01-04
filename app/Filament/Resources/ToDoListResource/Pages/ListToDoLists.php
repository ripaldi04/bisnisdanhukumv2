<?php

namespace App\Filament\Resources\ToDoListResource\Pages;

use App\Filament\Resources\ToDoListResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListToDoLists extends ListRecords
{
    protected static string $resource = ToDoListResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
