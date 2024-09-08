<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FraudAnalysisResource\Pages;
use App\Models\FraudAnalysis;
use App\Models\Company;
use App\Models\HorizontalAnalysis;
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

    protected static ?string $navigationIcon = 'heroicon-o-shield-check'; // Ikon di sidebar

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('company_id')
                    ->label('Company')
                    ->options(Company::all()->pluck('name', 'id')) // Memilih perusahaan
                    ->required()
                    ->reactive(),

                Select::make('horizontal_analysis_id')
                    ->label('Select Horizontal Analysis')
                    ->options(fn (callable $get) => HorizontalAnalysis::where('company_id', $get('company_id'))
                        ->pluck('year', 'id')) // Memilih analisis horizontal
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(fn($state, callable $set) => self::loadHorizontalData($state, $set)),

                TextInput::make('year')
                    ->label('Year')
                    ->numeric()
                    ->disabled(), // Disable karena ini dihitung dari Horizontal Analysis

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
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(), // Bulk delete action
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
     * Mengambil data dari Horizontal Analysis yang dipilih dan menghitung Beneish M-Score.
     */
    private static function loadHorizontalData($horizontalAnalysisId, callable $set)
    {
        $horizontalAnalysis = HorizontalAnalysis::find($horizontalAnalysisId);

        if ($horizontalAnalysis) {
            // Set year berdasarkan Horizontal Analysis
            $set('year', $horizontalAnalysis->year);

            // Menghitung rasio-rasio berdasarkan data Horizontal Analysis
            $dsri = ($horizontalAnalysis->account_receivables_difference ?? 1) / ($horizontalAnalysis->sales_difference ?? 1);
            $gmi = (($horizontalAnalysis->sales_difference - $horizontalAnalysis->cost_of_goods_sold_difference) ?? 1) /
                (($horizontalAnalysis->sales_difference ?? 1) - ($horizontalAnalysis->cost_of_goods_sold_difference ?? 1));
            $aqi = (($horizontalAnalysis->current_assets_difference + $horizontalAnalysis->plant_property_equipment_difference) ?? 1) / 
                ($horizontalAnalysis->total_assets_difference ?? 1);
            $sgi = ($horizontalAnalysis->sales_difference ?? 1) / ($horizontalAnalysis->previous_year_sales_difference ?? 1);
            $depi = ($horizontalAnalysis->depreciation_difference ?? 1) / ($horizontalAnalysis->plant_property_equipment_difference ?? 1);
            $sgai = ($horizontalAnalysis->sga_expenses_difference ?? 1) / ($horizontalAnalysis->sales_difference ?? 1);
            $lvgi = ($horizontalAnalysis->long_term_debt_difference ?? 1) / ($horizontalAnalysis->total_assets_difference ?? 1);
            $tata = ($horizontalAnalysis->working_capital_difference - $horizontalAnalysis->cash_difference - $horizontalAnalysis->current_taxes_payables_difference - $horizontalAnalysis->depreciation_amortization_difference) / ($horizontalAnalysis->total_assets_difference ?? 1);

            // Menambahkan batasan (clamping) agar nilai tidak terlalu besar/kecil
            $sgi = min(max($sgi, -999999), 999999);
            $dsri = min(max($dsri, -999999), 999999);
            $gmi = min(max($gmi, -999999), 999999);
            $aqi = min(max($aqi, -999999), 999999);
            $depi = min(max($depi, -999999), 999999);
            $sgai = min(max($sgai, -999999), 999999);
            $lvgi = min(max($lvgi, -999999), 999999);
            $tata = min(max($tata, -999999), 999999);

            $beneish_m_score = -4.84 + (0.920 * $dsri) + (0.528 * $gmi) + (0.404 * $aqi) + (0.892 * $sgi) + (0.115 * $depi) - (0.172 * $sgai) + (4.679 * $tata) - (0.327 * $lvgi);

            // Simpan hasil ke dalam form untuk ditampilkan di UI
            $set('dsri', $dsri);
            $set('gmi', $gmi);
            $set('aqi', $aqi);
            $set('sgi', $sgi);
            $set('depi', $depi);
            $set('sgai', $sgai);
            $set('lvgi', $lvgi);
            $set('tata', $tata);
            $set('beneish_m_score', $beneish_m_score);

            // Simpan ke database (insert/update Fraud Analysis)
            FraudAnalysis::updateOrCreate(
                [
                    'horizontal_analysis_id' => $horizontalAnalysis->id
                ],
                [
                    'company_id' => $horizontalAnalysis->company_id,
                    'year' => $horizontalAnalysis->year,
                    'dsri' => $dsri,
                    'gmi' => $gmi,
                    'aqi' => $aqi,
                    'sgi' => $sgi,
                    'depi' => $depi,
                    'sgai' => $sgai,
                    'lvgi' => $lvgi,
                    'tata' => $tata,
                    'beneish_m_score' => $beneish_m_score,
                ]
            );
        }
    }
}
