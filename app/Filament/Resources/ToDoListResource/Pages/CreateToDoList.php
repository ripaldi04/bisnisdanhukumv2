<?php

namespace App\Filament\Resources\ToDoListResource\Pages;

use App\Filament\Resources\ToDoListResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateToDoList extends CreateRecord
{
    protected static string $resource = ToDoListResource::class;
}
