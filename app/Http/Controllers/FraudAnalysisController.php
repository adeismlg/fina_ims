<?php

namespace App\Http\Controllers;

use App\Models\FraudAnalysis;
use App\Models\HorizontalAnalysis;
use App\Models\FinancialData;
use App\Models\Company;
use Illuminate\Http\Request;

class FraudAnalysisController extends Controller
{
    /**
     * Menampilkan halaman Print Fraud Analysis.
     */
    public function show(FraudAnalysis $record)
    {
        return view('fraud-analysis.view', [
            'record' => $record,
            'horizontalAnalysis' => HorizontalAnalysis::find($record->horizontal_analysis_id),
        ]);
    }

    public function print(FraudAnalysis $record)
    {
        // Cari Horizontal Analysis terkait
        $horizontalAnalysis = HorizontalAnalysis::find($record->horizontal_analysis_id);

        // Ambil data keuangan untuk tahun berjalan
        $financialDataCurrentYear = FinancialData::where('company_id', $record->company_id)
            ->where('year', $horizontalAnalysis->year)
            ->first();

        // Ambil data keuangan untuk tahun sebelumnya
        $financialDataPreviousYear = FinancialData::where('company_id', $record->company_id)
            ->where('year', $horizontalAnalysis->previous_year)
            ->first();

        // Jika data tahun sebelumnya tidak ditemukan, buat placeholder
        if (!$financialDataPreviousYear) {
            $financialDataPreviousYear = [
                'year' => $horizontalAnalysis->previous_year,
                'sales' => null,
                'cost_of_goods_sold' => null,
                'sga_expenses' => null,
                'depreciation' => null,
                'total_assets' => null,
                'account_receivables' => null,
                'current_assets' => null,
                'plant_property_equipment' => null,
                'current_liabilities' => null,
                'total_liabilities' => null,
                'long_term_debt' => null,
                'cash_flow_operations' => null,
            ];
        }

        // Kirim data ke view untuk ditampilkan
        return view('fraud-analysis.print', [
            'record' => $record,
            'horizontalAnalysis' => $horizontalAnalysis,
            'financialDataCurrentYear' => $financialDataCurrentYear,
            'financialDataPreviousYear' => $financialDataPreviousYear,
        ]);
    }
}
