<?php

namespace App\Imports;

use App\Models\FinancialData;
use App\Models\Company;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Log;

class FinancialDataImport implements ToModel, WithHeadingRow
{
    /**
     * This method is called for each row in the spreadsheet.
     * It either creates a new FinancialData entry or updates an existing one.
     */
    public function model(array $row)
    {
        // Cek apakah 'company_code' ada dan valid
        $companyId = isset($row['company_code']) ? $this->getCompanyId($row['company_code']) : null;

        // Periksa jika company_id valid
        if (!$companyId) {
            // Handle kasus jika company_id tidak ditemukan
            Log::warning('Company code not found for: ' . $row['company_code']);
            return null; // Atau Anda bisa memilih untuk membuang baris ini
        }

        // Menggunakan updateOrCreate untuk memasukkan atau memperbarui data
        return FinancialData::updateOrCreate(
            [
                'company_id' => $companyId,
                'year' => $row['year']
            ],
            [
                'sales' => $row['sales'] ?? null,
                'cost_of_goods_sold' => $row['cost_of_goods_sold'] ?? null,
                'current_assets' => $row['current_assets'] ?? null,
                'plant_property_equipment' => $row['plant_property_equipment'] ?? null,
                'sga_expenses' => $row['sga_expenses'] ?? null,
                'total_assets' => $row['total_assets'] ?? null,
                'depreciation' => $row['depreciation'] ?? null,
                'account_receivables' => $row['account_receivables'] ?? null,
                'long_term_debt' => $row['long_term_debt'] ?? null,
                'current_liabilities' => $row['current_liabilities'] ?? null,
                'working_capital' => $row['working_capital'] ?? null,
                'cash' => $row['cash'] ?? null,
                'current_taxes_payables' => $row['current_taxes_payables'] ?? null,
                'depreciation_amortization' => $row['depreciation_amortization'] ?? null,
            ]
        );
    }

    /**
     * This method is used to find the company ID based on a given company code.
     * Modify the query according to how the company code relates to your Company model.
     */
    // private function getCompanyId($companyCode)
    // {
    //     // Implementasi untuk mencari company_id berdasarkan company_code
    //     // Sesuaikan kolom pencarian sesuai dengan struktur database Anda
    //     return Company::where('code', $companyCode)->value('id');
    // }

    private function getCompanyId($companyCode)
    {
        // Gantilah 'code' dengan kolom yang sesuai dari tabel companies
        // Jika Anda mencari berdasarkan 'id':
        return Company::where('id', $companyCode)->value('id');
    }

}
