<?php

namespace App\Filament\Resources\PremiumMembershipResource\Pages;

use App\Filament\Resources\PremiumMembershipResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePremiumMembership extends CreateRecord
{
    protected static string $resource = PremiumMembershipResource::class;
}
