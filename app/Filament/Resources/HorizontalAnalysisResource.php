<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HorizontalAnalysisResource\Pages;
use App\Models\HorizontalAnalysis;
use App\Models\Company;
use App\Models\FinancialData;
use Filament\Resources\Resource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;

class HorizontalAnalysisResource extends Resource
{
    protected static ?string $model = HorizontalAnalysis::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('company_id')
                    ->label('Select Company')
                    ->options(Company::all()->pluck('name', 'id')) // Memilih perusahaan
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(fn($state, callable $set) => self::getAvailableYears($state, $set)),

                Select::make('year')
                    ->label('Select Year')
                    ->options(fn(callable $get) => self::getAvailableYears($get('company_id')))
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(fn($state, callable $set, callable $get) => self::loadFinancialData($get('company_id'), $state, $get('previous_year'), $set)),

                Select::make('previous_year')
                    ->label('Select Previous Year')
                    ->options(fn(callable $get) => self::getAvailableYears($get('company_id')))
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(fn($state, callable $set, callable $get) => self::loadFinancialData($get('company_id'), $get('year'), $state, $set)),

                // Semua field perbedaan
                TextInput::make('sales_difference')
                    ->label('Sales Difference')
                    ->disabled(),

                TextInput::make('cost_of_goods_sold_difference')
                    ->label('COGS Difference')
                    ->disabled(),

                TextInput::make('current_assets_difference')
                    ->label('Current Assets Difference')
                    ->disabled(),

                TextInput::make('plant_property_equipment_difference')
                    ->label('Plant, Property & Equipment Difference')
                    ->disabled(),

                TextInput::make('sga_expenses_difference')
                    ->label('SGA Expenses Difference')
                    ->disabled(),

                TextInput::make('total_assets_difference')
                    ->label('Total Assets Difference')
                    ->disabled(),

                TextInput::make('depreciation_difference')
                    ->label('Depreciation Difference')
                    ->disabled(),

                TextInput::make('account_receivables_difference')
                    ->label('Account Receivables Difference')
                    ->disabled(),

                TextInput::make('long_term_debt_difference')
                    ->label('Long Term Debt Difference')
                    ->disabled(),

                TextInput::make('current_liabilities_difference')
                    ->label('Current Liabilities Difference')
                    ->disabled(),

                TextInput::make('working_capital_difference')
                    ->label('Working Capital Difference')
                    ->disabled(),

                TextInput::make('cash_difference')
                    ->label('Cash Difference')
                    ->disabled(),

                TextInput::make('current_taxes_payables_difference')
                    ->label('Current Taxes Payables Difference')
                    ->disabled(),

                TextInput::make('depreciation_amortization_difference')
                    ->label('Depreciation & Amortization Difference')
                    ->disabled(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('company.name')->label('Company'),
                TextColumn::make('year')->label('Year'),
                TextColumn::make('previous_year')->label('Previous Year'),

                TextColumn::make('sales_difference')
                    ->label('Sales Difference')
                    ->formatStateUsing(fn($state) => 'Rp. ' . number_format($state, 0, ',', '.')),

                TextColumn::make('cost_of_goods_sold_difference')
                    ->label('COGS Difference')
                    ->formatStateUsing(fn($state) => 'Rp. ' . number_format($state, 0, ',', '.')),

                TextColumn::make('current_assets_difference')
                    ->label('Current Assets Difference')
                    ->formatStateUsing(fn($state) => 'Rp. ' . number_format($state, 0, ',', '.')),

                TextColumn::make('plant_property_equipment_difference')
                    ->label('Plant, Property & Equipment Difference')
                    ->formatStateUsing(fn($state) => 'Rp. ' . number_format($state, 0, ',', '.')),

                TextColumn::make('sga_expenses_difference')
                    ->label('SGA Expenses Difference')
                    ->formatStateUsing(fn($state) => 'Rp. ' . number_format($state, 0, ',', '.')),

                TextColumn::make('total_assets_difference')
                    ->label('Total Assets Difference')
                    ->formatStateUsing(fn($state) => 'Rp. ' . number_format($state, 0, ',', '.')),

                TextColumn::make('cash_difference')
                    ->label('Cash Difference')
                    ->formatStateUsing(fn($state) => 'Rp. ' . number_format($state, 0, ',', '.')),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('company')
                    ->label('Company')
                    ->relationship('company', 'name'),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(), // Bulk delete action
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHorizontalAnalyses::route('/'),
            'create' => Pages\CreateHorizontalAnalysis::route('/create'),
            'edit' => Pages\EditHorizontalAnalysis::route('/{record}/edit'),
        ];
    }

    private static function getAvailableYears($companyId)
    {
        if (!$companyId) {
            return [];
        }

        return FinancialData::where('company_id', $companyId)
            ->orderBy('year', 'desc')
            ->pluck('year', 'year')
            ->toArray();
    }

    private static function loadFinancialData($companyId, $year, $previousYear, callable $set)
    {
        if ($companyId && $year && $previousYear) {
            $currentYearData = FinancialData::where('company_id', $companyId)
                ->where('year', $year)
                ->first();

            $previousYearData = FinancialData::where('company_id', $companyId)
                ->where('year', $previousYear)
                ->first();

            if ($currentYearData && $previousYearData) {
                $set('sales_difference', $currentYearData->sales - $previousYearData->sales);
                $set('cost_of_goods_sold_difference', $currentYearData->cost_of_goods_sold - $previousYearData->cost_of_goods_sold);
                $set('current_assets_difference', $currentYearData->current_assets - $previousYearData->current_assets);
                $set('plant_property_equipment_difference', $currentYearData->plant_property_equipment - $previousYearData->plant_property_equipment);
                $set('sga_expenses_difference', $currentYearData->sga_expenses - $previousYearData->sga_expenses);
                $set('total_assets_difference', $currentYearData->total_assets - $previousYearData->total_assets);
                $set('depreciation_difference', $currentYearData->depreciation - $previousYearData->depreciation);
                $set('account_receivables_difference', $currentYearData->account_receivables - $previousYearData->account_receivables);
                $set('long_term_debt_difference', $currentYearData->long_term_debt - $previousYearData->long_term_debt);
                $set('current_liabilities_difference', $currentYearData->current_liabilities - $previousYearData->current_liabilities);
                $set('working_capital_difference', $currentYearData->working_capital - $previousYearData->working_capital);
                $set('cash_difference', $currentYearData->cash - $previousYearData->cash);
                $set('current_taxes_payables_difference', $currentYearData->current_taxes_payables - $previousYearData->current_taxes_payables);
                $set('depreciation_amortization_difference', $currentYearData->depreciation_amortization - $previousYearData->depreciation_amortization);
            }
        }
    }
}
