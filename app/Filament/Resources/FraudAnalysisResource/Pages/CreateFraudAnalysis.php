<?php

namespace App\Filament\Resources\FraudAnalysisResource\Pages;

use App\Filament\Resources\FraudAnalysisResource;
use Filament\Resources\Pages\CreateRecord;
use App\Models\HorizontalAnalysis;

class CreateFraudAnalysis extends CreateRecord
{
    protected static string $resource = FraudAnalysisResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
{
    $horizontalAnalysis = HorizontalAnalysis::find($data['horizontal_analysis_id']);

    if ($horizontalAnalysis) {
        // Perhitungan rasio-rasio berdasarkan Horizontal Analysis
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

        // Tambahkan batasan nilai (clamping) agar tidak terlalu besar atau kecil
        $sgi = min(max($sgi, -999999), 999999);
        $dsri = min(max($dsri, -999999), 999999);
        $gmi = min(max($gmi, -999999), 999999);
        $aqi = min(max($aqi, -999999), 999999);
        $depi = min(max($depi, -999999), 999999);
        $sgai = min(max($sgai, -999999), 999999);
        $lvgi = min(max($lvgi, -999999), 999999);
        $tata = min(max($tata, -999999), 999999);

        // Hitung Beneish M-Score
        $beneish_m_score = -4.84 + (0.920 * $dsri) + (0.528 * $gmi) + (0.404 * $aqi) + (0.892 * $sgi) + (0.115 * $depi) - (0.172 * $sgai) + (4.679 * $tata) - (0.327 * $lvgi);

        // Memasukkan hasil perhitungan ke dalam data yang akan disimpan
        $data['dsri'] = $dsri;
        $data['gmi'] = $gmi;
        $data['aqi'] = $aqi;
        $data['sgi'] = $sgi;
        $data['depi'] = $depi;
        $data['sgai'] = $sgai;
        $data['lvgi'] = $lvgi;
        $data['tata'] = $tata;
        $data['beneish_m_score'] = $beneish_m_score;

        // Set year sesuai dengan data Horizontal Analysis
        $data['year'] = $horizontalAnalysis->year;
    }

    return $data;
}

}
