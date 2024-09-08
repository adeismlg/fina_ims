<?php

namespace App\Filament\Pages;

use App\Models\Company;
use App\Models\FinancialData;
use App\Models\HorizontalAnalysis;
use Filament\Pages\Page;
use Filament\Forms;
use Illuminate\Support\Facades\Log;

class HorizontalAnalysisCalculator extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-calculator';
    protected static string $view = 'filament.pages.horizontal-analysis-calculator';

    public $company_id;
    public $year;
    public $previous_year;
    public $currentYearData;
    public $previousYearData;
    public $calculatedData;

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\Select::make('company_id')
                ->label('Select Company')
                ->options(Company::all()->pluck('name', 'id'))
                ->required()
                ->reactive()
                ->afterStateUpdated(fn ($state) => $this->resetYearSelection()),
            Forms\Components\Select::make('year')
                ->label('Select Year')
                ->options(fn (callable $get) => $this->getAvailableYears($get('company_id')))
                ->required()
                ->reactive()
                ->afterStateUpdated(fn ($state) => $this->loadFinancialData()),
            Forms\Components\Select::make('previous_year')
                ->label('Select Previous Year')
                ->options(fn (callable $get) => $this->getAvailableYears($get('company_id')))
                ->required()
                ->reactive()
                ->afterStateUpdated(fn ($state) => $this->loadFinancialData()),
        ];
    }

    protected function getAvailableYears($companyId): array
    {
        if (!$companyId) {
            return [];
        }

        return FinancialData::where('company_id', $companyId)
            ->orderBy('year', 'desc')
            ->pluck('year', 'year')
            ->toArray();
    }

    public function resetYearSelection()
    {
        $this->year = null;
        $this->previous_year = null;
        $this->currentYearData = null;
        $this->previousYearData = null;
        $this->calculatedData = null;
    }

    public function loadFinancialData(): void
    {
        if ($this->company_id && $this->year && $this->previous_year) {
            $this->currentYearData = FinancialData::where('company_id', $this->company_id)
                ->where('year', $this->year)
                ->first();

            $this->previousYearData = FinancialData::where('company_id', $this->company_id)
                ->where('year', $this->previous_year)
                ->first();

            if ($this->currentYearData && $this->previousYearData) {
                $this->calculateHorizontalAnalysis();
            }
        } else {
            $this->currentYearData = null;
            $this->previousYearData = null;
            $this->calculatedData = null;
        }
    }

    public function calculateHorizontalAnalysis(): void
    {
        if ($this->currentYearData && $this->previousYearData) {
            $this->calculatedData = [
                'sales_difference' => $this->currentYearData->sales - $this->previousYearData->sales,
                'cost_of_goods_sold_difference' => $this->currentYearData->cost_of_goods_sold - $this->previousYearData->cost_of_goods_sold,
                'current_assets_difference' => $this->currentYearData->current_assets - $this->previousYearData->current_assets,
                'plant_property_equipment_difference' => $this->currentYearData->plant_property_equipment - $this->previousYearData->plant_property_equipment,
                'sga_expenses_difference' => $this->currentYearData->sga_expenses - $this->previousYearData->sga_expenses,
                'total_assets_difference' => $this->currentYearData->total_assets - $this->previousYearData->total_assets,
                'depreciation_difference' => $this->currentYearData->depreciation - $this->previousYearData->depreciation,
                'account_receivables_difference' => $this->currentYearData->account_receivables - $this->previousYearData->account_receivables,
                'long_term_debt_difference' => $this->currentYearData->long_term_debt - $this->previousYearData->long_term_debt,
                'current_liabilities_difference' => $this->currentYearData->current_liabilities - $this->previousYearData->current_liabilities,
                'working_capital_difference' => $this->currentYearData->working_capital - $this->previousYearData->working_capital,
                'cash_difference' => $this->currentYearData->cash - $this->previousYearData->cash,
                'current_taxes_payables_difference' => $this->currentYearData->current_taxes_payables - $this->previousYearData->current_taxes_payables,
                'depreciation_amortization_difference' => $this->currentYearData->depreciation_amortization - $this->previousYearData->depreciation_amortization,
            ];
        }
    }
    public function saveHorizontalAnalysis(): void
    {
        $existingRecord = HorizontalAnalysis::where('company_id', $this->company_id)
                                            ->where('year', $this->year)
                                            ->first();

        if ($existingRecord) {
            $existingRecord->update([
                'previous_year' => $this->previous_year,
                'sales_difference' => $this->calculatedData['sales_difference'],
                'cost_of_goods_sold_difference' => $this->calculatedData['cost_of_goods_sold_difference'],
                'current_assets_difference' => $this->calculatedData['current_assets_difference'],
                'plant_property_equipment_difference' => $this->calculatedData['plant_property_equipment_difference'],
                'sga_expenses_difference' => $this->calculatedData['sga_expenses_difference'],
                'total_assets_difference' => $this->calculatedData['total_assets_difference'],
                'depreciation_difference' => $this->calculatedData['depreciation_difference'],
                'account_receivables_difference' => $this->calculatedData['account_receivables_difference'],
                'long_term_debt_difference' => $this->calculatedData['long_term_debt_difference'],
                'current_liabilities_difference' => $this->calculatedData['current_liabilities_difference'],
                'working_capital_difference' => $this->calculatedData['working_capital_difference'],
                'cash_difference' => $this->calculatedData['cash_difference'],
                'current_taxes_payables_difference' => $this->calculatedData['current_taxes_payables_difference'],
                'depreciation_amortization_difference' => $this->calculatedData['depreciation_amortization_difference'],
            ]);

            $this->notify('success', 'Horizontal Analysis updated successfully.');
        } else {
            HorizontalAnalysis::create([
                'company_id' => $this->company_id,
                'year' => $this->year,
                'previous_year' => $this->previous_year,
                'sales_difference' => $this->calculatedData['sales_difference'],
                'cost_of_goods_sold_difference' => $this->calculatedData['cost_of_goods_sold_difference'],
                'current_assets_difference' => $this->calculatedData['current_assets_difference'],
                'plant_property_equipment_difference' => $this->calculatedData['plant_property_equipment_difference'],
                'sga_expenses_difference' => $this->calculatedData['sga_expenses_difference'],
                'total_assets_difference' => $this->calculatedData['total_assets_difference'],
                'depreciation_difference' => $this->calculatedData['depreciation_difference'],
                'account_receivables_difference' => $this->calculatedData['account_receivables_difference'],
                'long_term_debt_difference' => $this->calculatedData['long_term_debt_difference'],
                'current_liabilities_difference' => $this->calculatedData['current_liabilities_difference'],
                'working_capital_difference' => $this->calculatedData['working_capital_difference'],
                'cash_difference' => $this->calculatedData['cash_difference'],
                'current_taxes_payables_difference' => $this->calculatedData['current_taxes_payables_difference'],
                'depreciation_amortization_difference' => $this->calculatedData['depreciation_amortization_difference'],
            ]);

            $this->notify('success', 'Horizontal Analysis created successfully.');
        }
    }

}
