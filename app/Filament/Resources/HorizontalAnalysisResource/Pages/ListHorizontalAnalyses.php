<?php

namespace App\Filament\Resources\HorizontalAnalysisResource\Pages;

use App\Filament\Resources\HorizontalAnalysisResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHorizontalAnalyses extends ListRecords
{
    protected static string $resource = HorizontalAnalysisResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
