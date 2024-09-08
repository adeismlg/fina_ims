<?php

namespace App\Filament\Resources\HorizontalAnalysisResource\Pages;

use App\Filament\Resources\HorizontalAnalysisResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHorizontalAnalysis extends EditRecord
{
    protected static string $resource = HorizontalAnalysisResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
