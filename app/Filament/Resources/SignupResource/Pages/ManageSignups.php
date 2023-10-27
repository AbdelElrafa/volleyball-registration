<?php

namespace App\Filament\Resources\SignupResource\Pages;

use App\Filament\Resources\SignupResource;
use Filament\Resources\Pages\ManageRecords;

class ManageSignups extends ManageRecords
{
    protected static string $resource = SignupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //
        ];
    }
}
