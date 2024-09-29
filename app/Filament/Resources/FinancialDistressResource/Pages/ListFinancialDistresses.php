<?php

namespace App\Filament\Resources\FinancialDistressResource\Pages;

use App\Filament\Resources\FinancialDistressResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFinancialDistresses extends ListRecords
{
    protected static string $resource = FinancialDistressResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
