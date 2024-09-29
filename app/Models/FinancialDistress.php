<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancialDistress extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'year',
        'current_ratio',    // Likuiditas (X1)
        'debt_to_asset_ratio', // Leverage (X2)
        'return_on_assets',  // Profitabilitas (X3)
        'z_score',         // Nilai Z-Score
        'classification',  // Klasifikasi hasil Z-Score
    ];

    // Relasi ke model Company
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
