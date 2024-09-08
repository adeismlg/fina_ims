<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancialData extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'year',
        'sales',
        'cost_of_goods_sold',
        'current_assets',
        'plant_property_equipment',
        'sga_expenses',
        'total_assets',
        'depreciation',
        'account_receivables',
        'long_term_debt',
        'current_liabilities',
        'working_capital',
        'cash',
        'current_taxes_payables',
        'depreciation_amortization',
    ];

    // Menambahkan relasi ke Company
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
