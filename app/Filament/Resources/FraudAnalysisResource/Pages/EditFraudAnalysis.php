<?php

namespace App\Filament\Resources\FraudAnalysisResource\Pages;

use App\Filament\Resources\FraudAnalysisResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFraudAnalysis extends EditRecord
{
    protected static string $resource = FraudAnalysisResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
