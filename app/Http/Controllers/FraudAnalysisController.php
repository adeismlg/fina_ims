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
        // Mengambil data dari FraudAnalysis, HorizontalAnalysis, dan FinancialData
        $horizontalAnalysis = HorizontalAnalysis::find($record->horizontal_analysis_id);
        $financialDataCurrentYear = FinancialData::where('company_id', $record->company_id)
            ->where('year', $horizontalAnalysis->year)
            ->first();
        $financialDataPreviousYear = FinancialData::where('company_id', $record->company_id)
            ->where('year', $horizontalAnalysis->previous_year)
            ->first();

        // Mengirimkan data ke view untuk ditampilkan
        return view('fraud-analysis.print', [
            'record' => $record,
            'horizontalAnalysis' => $horizontalAnalysis,
            'financialDataCurrentYear' => $financialDataCurrentYear,
            'financialDataPreviousYear' => $financialDataPreviousYear,
        ]);
    }
}
