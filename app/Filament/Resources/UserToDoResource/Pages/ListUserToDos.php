<?php

namespace App\Filament\Resources\UserToDoResource\Pages;

use App\Filament\Resources\UserToDoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUserToDos extends ListRecords
{
    protected static string $resource = UserToDoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
