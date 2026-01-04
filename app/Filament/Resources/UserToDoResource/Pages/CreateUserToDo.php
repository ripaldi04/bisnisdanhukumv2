<?php

namespace App\Filament\Resources\UserToDoResource\Pages;

use App\Filament\Resources\UserToDoResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateUserToDo extends CreateRecord
{
    protected static string $resource = UserToDoResource::class;
}
