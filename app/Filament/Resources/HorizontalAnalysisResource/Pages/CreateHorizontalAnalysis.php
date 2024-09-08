<?php

namespace App\Filament\Resources\HorizontalAnalysisResource\Pages;

use App\Filament\Resources\HorizontalAnalysisResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Models\HorizontalAnalysis;
use Illuminate\Support\Facades\Log;

class CreateHorizontalAnalysis extends CreateRecord
{
    protected static string $resource = HorizontalAnalysisResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Debugging: Tambahkan log untuk memastikan data masuk
        Log::info('Data before mutation:', $data);

        $companyId = $data['company_id'];
        $year = $data['year'];
        $previousYear = $data['previous_year'];

        $currentYearData = \App\Models\FinancialData::where('company_id', $companyId)
            ->where('year', $year)
            ->first();

        $previousYearData = \App\Models\FinancialData::where('company_id', $companyId)
            ->where('year', $previousYear)
            ->first();

        if ($currentYearData && $previousYearData) {
            $data['sales_difference'] = $currentYearData->sales - $previousYearData->sales;
            $data['cost_of_goods_sold_difference'] = $currentYearData->cost_of_goods_sold - $previousYearData->cost_of_goods_sold;
            $data['current_assets_difference'] = $currentYearData->current_assets - $previousYearData->current_assets;
            $data['plant_property_equipment_difference'] = $currentYearData->plant_property_equipment - $previousYearData->plant_property_equipment;
            $data['sga_expenses_difference'] = $currentYearData->sga_expenses - $previousYearData->sga_expenses;
            $data['total_assets_difference'] = $currentYearData->total_assets - $previousYearData->total_assets;
            $data['depreciation_difference'] = $currentYearData->depreciation - $previousYearData->depreciation;
            $data['account_receivables_difference'] = $currentYearData->account_receivables - $previousYearData->account_receivables;
            $data['long_term_debt_difference'] = $currentYearData->long_term_debt - $previousYearData->long_term_debt;
            $data['current_liabilities_difference'] = $currentYearData->current_liabilities - $previousYearData->current_liabilities;
            $data['working_capital_difference'] = $currentYearData->working_capital - $previousYearData->working_capital;
            $data['cash_difference'] = $currentYearData->cash - $previousYearData->cash;
            $data['current_taxes_payables_difference'] = $currentYearData->current_taxes_payables - $previousYearData->current_taxes_payables;
            $data['depreciation_amortization_difference'] = $currentYearData->depreciation_amortization - $previousYearData->depreciation_amortization;

            // Debugging: Tambahkan log setelah mutasi
            Log::info('Data after mutation:', $data);
        }

        return $data;
    }
}
