<?php

namespace App\Filament\Resources\PremiumMembershipResource\Pages;

use App\Filament\Resources\PremiumMembershipResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPremiumMembership extends EditRecord
{
    protected static string $resource = PremiumMembershipResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
