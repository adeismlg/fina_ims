<?php

namespace App\Filament\Resources\FraudAnalysisResource\Pages;

use App\Filament\Resources\FraudAnalysisResource;
use Filament\Resources\Pages\CreateRecord;
use App\Models\HorizontalAnalysis;
use App\Models\FinancialData;

class CreateFraudAnalysis extends CreateRecord
{
    protected static string $resource = FraudAnalysisResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Ambil data Horizontal Analysis
        $horizontalAnalysis = HorizontalAnalysis::find($data['horizontal_analysis_id']);
        
        // Ambil data Financial Data berdasarkan financial_data_id
        $financialData = FinancialData::find($data['financial_data_id']);

        if ($financialData) {
            // Ambil data keuangan dari FinancialData
            $sales_t = $financialData->sales ?? 1;
            $sales_t_1 = FinancialData::where('company_id', $financialData->company_id)
                ->where('year', $financialData->year - 1)
                ->value('sales') ?? 1;

            $cogs_t = $financialData->cost_of_goods_sold ?? 1;
            $cogs_t_1 = FinancialData::where('company_id', $financialData->company_id)
                ->where('year', $financialData->year - 1)
                ->value('cost_of_goods_sold') ?? 1;

            $net_receivables_t = $financialData->account_receivables ?? 1;
            $net_receivables_t_1 = FinancialData::where('company_id', $financialData->company_id)
                ->where('year', $financialData->year - 1)
                ->value('account_receivables') ?? 1;

            $total_assets_t = $financialData->total_assets ?? 1;
            $total_assets_t_1 = FinancialData::where('company_id', $financialData->company_id)
                ->where('year', $financialData->year - 1)
                ->value('total_assets') ?? 1;

            $current_assets_t = $financialData->current_assets ?? 1;
            $current_assets_t_1 = FinancialData::where('company_id', $financialData->company_id)
                ->where('year', $financialData->year - 1)
                ->value('current_assets') ?? 1;

            $fixed_assets_t = $financialData->plant_property_equipment ?? 1;
            $fixed_assets_t_1 = FinancialData::where('company_id', $financialData->company_id)
                ->where('year', $financialData->year - 1)
                ->value('plant_property_equipment') ?? 1;

            $depreciation_t = $financialData->depreciation ?? 1;
            $depreciation_t_1 = FinancialData::where('company_id', $financialData->company_id)
                ->where('year', $financialData->year - 1)
                ->value('depreciation') ?? 1;

            $sga_t = $financialData->sga_expenses ?? 1;
            $sga_t_1 = FinancialData::where('company_id', $financialData->company_id)
                ->where('year', $financialData->year - 1)
                ->value('sga_expenses') ?? 1;

            $total_liabilities_t = $financialData->current_liabilities ?? 1;
            $total_liabilities_t_1 = FinancialData::where('company_id', $financialData->company_id)
                ->where('year', $financialData->year - 1)
                ->value('current_liabilities') ?? 1;

            // Perhitungan rasio berdasarkan data keuangan
            $dsri = ($net_receivables_t / $sales_t) / ($net_receivables_t_1 / $sales_t_1);
            $gmi = (($sales_t - $cogs_t) / $sales_t) / (($sales_t_1 - $cogs_t_1) / $sales_t_1);
            $aqi = (($current_assets_t + $fixed_assets_t) / $total_assets_t) / (($current_assets_t_1 + $fixed_assets_t_1) / $total_assets_t_1);
            $sgi = $sales_t / $sales_t_1;
            $depi = ($depreciation_t_1 / ($fixed_assets_t_1 + $depreciation_t_1)) / ($depreciation_t / ($fixed_assets_t + $depreciation_t));
            $sgai = ($sga_t / $sales_t) / ($sga_t_1 / $sales_t_1);
            $lvgi = ($total_liabilities_t / $total_assets_t) / ($total_liabilities_t_1 / $total_assets_t_1);
        }

        if ($horizontalAnalysis) {
            // Hanya TATA yang dihitung dari Horizontal Analysis
            $working_capital_diff = $horizontalAnalysis->working_capital_difference ?? 0;
            $cash_diff = $horizontalAnalysis->cash_difference ?? 0;
            $tax_payable_diff = $horizontalAnalysis->current_taxes_payables_difference ?? 0;
            $depreciation_amortization_diff = $horizontalAnalysis->depreciation_amortization_difference ?? 0;
            $total_assets_diff = $horizontalAnalysis->total_assets_difference ?? 1;

            // Perhitungan TATA
            $tata = ($working_capital_diff - $cash_diff - $tax_payable_diff - $depreciation_amortization_diff) / $total_assets_diff;
        }

        // Clamping nilai rasio
        $dsri = min(max($dsri ?? 0, -1000000), 1000000);
        $gmi = min(max($gmi ?? 0, -1000000), 1000000);
        $aqi = min(max($aqi ?? 0, -1000000), 1000000);
        $sgi = min(max($sgi ?? 0, -1000000), 1000000);
        $depi = min(max($depi ?? 0, -1000000), 1000000);
        $sgai = min(max($sgai ?? 0, -1000000), 1000000);
        $lvgi = min(max($lvgi ?? 0, -1000000), 1000000);
        $tata = min(max($tata ?? 0, -1000000), 1000000);

        // Hitung Beneish M-Score
        $beneish_m_score = -4.84 + (0.920 * $dsri) + (0.528 * $gmi) + (0.404 * $aqi) + (0.892 * $sgi) + (0.115 * $depi) - (0.172 * $sgai) + (4.679 * $tata) - (0.327 * $lvgi);

        // Simpan hasil ke dalam data yang akan disimpan
        $data['dsri'] = $dsri;
        $data['gmi'] = $gmi;
        $data['aqi'] = $aqi;
        $data['sgi'] = $sgi;
        $data['depi'] = $depi;
        $data['sgai'] = $sgai;
        $data['lvgi'] = $lvgi;
        $data['tata'] = $tata;
        $data['beneish_m_score'] = $beneish_m_score;

        // Set year sesuai dengan data financial atau horizontal analysis
        $data['year'] = $financialData->year ?? $horizontalAnalysis->year;

        return $data;
    }
}
