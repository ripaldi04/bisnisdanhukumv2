<?php

namespace App\Filament\Resources\LiveCourseResource\Pages;

use App\Filament\Resources\LiveCourseResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLiveCourse extends EditRecord
{
    protected static string $resource = LiveCourseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
