<?php

namespace App\Filament\Resources\UniquenessResource\Pages;

use App\Filament\Resources\UniquenessResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateUniqueness extends CreateRecord
{
    protected static string $resource = UniquenessResource::class;
}
