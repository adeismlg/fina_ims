<?php

namespace App\Filament\Resources\FinancialDistressResource\Pages;

use App\Filament\Resources\FinancialDistressResource;
use Filament\Resources\Pages\CreateRecord;
use App\Models\FinancialData;
use App\Models\Company;

class CreateFinancialDistress extends CreateRecord
{
    protected static string $resource = FinancialDistressResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Mengambil data keuangan
        $financialData = FinancialData::where('company_id', $data['company_id'])
            ->where('year', $data['year'])
            ->first();

        if ($financialData) {
            // Hitung Likuiditas (Current Ratio)
            $X1 = $financialData->current_assets / $financialData->current_liabilities;

            // Hitung Leverage (Debt to Asset Ratio)
            $X2 = ($financialData->current_liabilities + $financialData->long_term_debt) / $financialData->total_assets;

            // Hitung Profitabilitas (Return on Assets)
            $X3 = $financialData->net_income / $financialData->total_assets;

            // Hitung Z-Score
            $ZScore = -4.849785 - (0.770748 * $X1) + (1.651952 * $X2) - (53.04795 * $X3);

            // Klasifikasi berdasarkan nilai Z-Score
            if ($ZScore < 1.80) {
                $classification = 'Distress Zone';
            } elseif ($ZScore >= 1.80 && $ZScore <= 2.99) {
                $classification = 'Grey Area';
            } else {
                $classification = 'Non-Distress Zone';
            }

            // Tambahkan hasil perhitungan ke dalam data
            $data['current_ratio'] = $X1;
            $data['debt_to_asset_ratio'] = $X2;
            $data['return_on_assets'] = $X3;
            $data['z_score'] = $ZScore;
            $data['classification'] = $classification;
        }

        return $data;
    }
}
