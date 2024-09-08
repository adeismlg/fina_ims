<?php

namespace App\Filament\Resources\FraudAnalysisResource\Pages;

use App\Filament\Resources\FraudAnalysisResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFraudAnalyses extends ListRecords
{
    protected static string $resource = FraudAnalysisResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
