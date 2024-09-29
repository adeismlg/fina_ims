<?php

namespace App\Filament\Resources\FinancialDistressResource\Pages;

use App\Filament\Resources\FinancialDistressResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFinancialDistress extends EditRecord
{
    protected static string $resource = FinancialDistressResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
