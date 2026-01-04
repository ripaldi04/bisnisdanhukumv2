<?php

namespace App\Filament\Resources\EmailRecipientResource\Pages;

use App\Filament\Resources\EmailRecipientResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageEmailRecipients extends ManageRecords
{
    protected static string $resource = EmailRecipientResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
