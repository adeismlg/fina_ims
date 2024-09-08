<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HorizontalAnalysis extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'year',
        'previous_year',
        'sales_difference',
        'cost_of_goods_sold_difference',
        'current_assets_difference',
        'plant_property_equipment_difference',
        'sga_expenses_difference',
        'total_assets_difference',
        'depreciation_difference',
        'account_receivables_difference',
        'long_term_debt_difference',
        'current_liabilities_difference',
        'working_capital_difference',
        'cash_difference',
        'current_taxes_payables_difference',
        'depreciation_amortization_difference',
    ];

    /**
     * Relasi ke model Company.
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
