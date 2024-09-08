<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FraudAnalysisResource\Pages;
use App\Models\FraudAnalysis;
use App\Models\Company;
use App\Models\HorizontalAnalysis;
use App\Models\FinancialData;
use Filament\Resources\Resource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;

class FraudAnalysisResource extends Resource
{
    protected static ?string $model = FraudAnalysis::class;

    protected static ?string $navigationIcon = 'heroicon-o-shield-check'; 

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('company_id')
                    ->label('Company')
                    ->options(Company::all()->pluck('name', 'id'))
                    ->required()
                    ->reactive(),

                Select::make('horizontal_analysis_id')
                    ->label('Select Horizontal Analysis')
                    ->options(fn (callable $get) => HorizontalAnalysis::where('company_id', $get('company_id'))
                        ->pluck('year', 'id'))
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(fn($state, callable $set) => self::loadHorizontalData($state, $set)),

                Select::make('financial_data_id')
                    ->label('Select Financial Data (Year)')
                    ->options(fn (callable $get) => FinancialData::where('company_id', $get('company_id'))
                        ->pluck('year', 'id'))
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(fn($state, callable $set) => self::loadFinancialData($state, $set)),

                TextInput::make('year')
                    ->label('Year')
                    ->numeric()
                    ->disabled(),

                TextInput::make('dsri')->label('DSRI')->numeric()->disabled(),
                TextInput::make('gmi')->label('GMI')->numeric()->disabled(),
                TextInput::make('aqi')->label('AQI')->numeric()->disabled(),
                TextInput::make('sgi')->label('SGI')->numeric()->disabled(),
                TextInput::make('depi')->label('DEPI')->numeric()->disabled(),
                TextInput::make('sgai')->label('SGAI')->numeric()->disabled(),
                TextInput::make('lvgi')->label('LVGI')->numeric()->disabled(),
                TextInput::make('tata')->label('TATA')->numeric()->disabled(),
                TextInput::make('beneish_m_score')->label('Beneish M-Score')->numeric()->disabled(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('company.name')->label('Company'),
                TextColumn::make('year')->label('Year'),
                TextColumn::make('beneish_m_score')->label('Beneish M-Score'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('company')
                    ->label('Company')
                    ->relationship('company', 'name'),
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->label('View')
                    ->icon('heroicon-o-eye')
                    ->url(fn (FraudAnalysis $record) => route('fraud-analysis.view', $record->id))
                    ->openUrlInNewTab(),

                Tables\Actions\DeleteAction::make(),

                Tables\Actions\Action::make('print')
                    ->label('Print')
                    ->icon('heroicon-o-printer')
                    ->url(fn (FraudAnalysis $record) => route('fraud-analysis.print', $record->id))
                    ->openUrlInNewTab(),

            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFraudAnalyses::route('/'),
            'create' => Pages\CreateFraudAnalysis::route('/create'),
            'edit' => Pages\EditFraudAnalysis::route('/{record}/edit'),
        ];
    }

    /**
     * Memuat data Horizontal Analysis yang dipilih dan menghitung TATA.
     */
    private static function loadHorizontalData($horizontalAnalysisId, callable $set)
    {
        $horizontalAnalysis = HorizontalAnalysis::find($horizontalAnalysisId);

        if ($horizontalAnalysis) {
            $company_id = $horizontalAnalysis->company_id; // Mendapatkan company_id dari HorizontalAnalysis
            $set('year', $horizontalAnalysis->year);

            // Perhitungan TATA menggunakan Horizontal Analysis
            $working_capital_diff = $horizontalAnalysis->working_capital_difference ?? 0;
            $cash_diff = $horizontalAnalysis->cash_difference ?? 0;
            $tax_payable_diff = $horizontalAnalysis->current_taxes_payables_difference ?? 0;
            $depreciation_amortization_diff = $horizontalAnalysis->depreciation_amortization_difference ?? 0;
            $total_assets_diff = $horizontalAnalysis->total_assets_difference ?? 1;

            $tata = ($working_capital_diff - $cash_diff - $tax_payable_diff - $depreciation_amortization_diff) / $total_assets_diff;
            $tata = min(max($tata, -999999), 999999);

            $set('tata', $tata);

            // Update Fraud Analysis untuk TATA
            FraudAnalysis::updateOrCreate(
                [
                    'horizontal_analysis_id' => $horizontalAnalysis->id
                ],
                [
                    'company_id' => $company_id, // Pastikan company_id diisi
                    'year' => $horizontalAnalysis->year,
                    'tata' => $tata,
                ]
            );
        }
    }

    /**
     * Memuat data Financial Analysis yang dipilih dan menghitung rasio lainnya.
     */
    private static function loadFinancialData($financialDataId, callable $set)
    {
        $financialData = FinancialData::find($financialDataId);

        if ($financialData) {
            $company_id = $financialData->company_id; // Mendapatkan company_id dari FinancialData
            $year = $financialData->year;

            $sales_t_1 = FinancialData::where('company_id', $company_id)
                ->where('year', $year - 1)
                ->first();

            if (!$sales_t_1) {
                return;
            }

            // Menghitung rasio Beneish
            $dsri = ($financialData->account_receivables / $financialData->sales) / ($sales_t_1->account_receivables / $sales_t_1->sales);
            $gmi = (($financialData->sales - $financialData->cost_of_goods_sold) / $financialData->sales) /
                (($sales_t_1->sales - $sales_t_1->cost_of_goods_sold) / $sales_t_1->sales);
            $aqi = (($financialData->current_assets + $financialData->plant_property_equipment) / $financialData->total_assets) /
                (($sales_t_1->current_assets + $sales_t_1->plant_property_equipment) / $sales_t_1->total_assets);
            $sgi = $financialData->sales / $sales_t_1->sales;
            $depi = ($sales_t_1->depreciation / ($sales_t_1->plant_property_equipment + $sales_t_1->depreciation)) /
                ($financialData->depreciation / ($financialData->plant_property_equipment + $financialData->depreciation));
            $sgai = ($financialData->sga_expenses / $financialData->sales) / ($sales_t_1->sga_expenses / $sales_t_1->sales);
            $lvgi = ($financialData->current_liabilities / $financialData->total_assets) /
                ($sales_t_1->current_liabilities / $sales_t_1->total_assets);

            $dsri = min(max($dsri, -999999), 999999);
            $gmi = min(max($gmi, -999999), 999999);
            $aqi = min(max($aqi, -999999), 999999);
            $sgi = min(max($sgi, -999999), 999999);
            $depi = min(max($depi, -999999), 999999);
            $sgai = min(max($sgai, -999999), 999999);
            $lvgi = min(max($lvgi, -999999), 999999);

            $beneish_m_score = -4.84 + (0.920 * $dsri) + (0.528 * $gmi) + (0.404 * $aqi) + (0.892 * $sgi) + (0.115 * $depi) - (0.172 * $sgai) + (4.679 * $lvgi);

            // Set hasil perhitungan di form
            $set('dsri', $dsri);
            $set('gmi', $gmi);
            $set('aqi', $aqi);
            $set('sgi', $sgi);
            $set('depi', $depi);
            $set('sgai', $sgai);
            $set('lvgi', $lvgi);
            $set('beneish_m_score', $beneish_m_score);

            // Update Fraud Analysis
            FraudAnalysis::updateOrCreate(
                [
                    'financial_data_id' => $financialData->id
                ],
                [
                    'company_id' => $company_id, // Pastikan company_id diisi
                    'year' => $financialData->year,
                    'dsri' => $dsri,
                    'gmi' => $gmi,
                    'aqi' => $aqi,
                    'sgi' => $sgi,
                    'depi' => $depi,
                    'sgai' => $sgai,
                    'lvgi' => $lvgi,
                    'beneish_m_score' => $beneish_m_score,
                ]
            );
        }
    }
}
