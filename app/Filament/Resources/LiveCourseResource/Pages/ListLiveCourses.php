<?php

namespace App\Filament\Resources\LiveCourseResource\Pages;

use App\Filament\Resources\LiveCourseResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLiveCourses extends ListRecords
{
    protected static string $resource = LiveCourseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
