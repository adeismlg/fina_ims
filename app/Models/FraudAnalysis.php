<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FraudAnalysis extends Model
{
    use HasFactory;

    // Kolom yang dapat diisi (fillable) saat melakukan insert/update
    protected $fillable = [
        'company_id',
        'horizontal_analysis_id',
        'year',
        'dsri',
        'gmi',
        'aqi',
        'sgi',
        'depi',
        'sgai',
        'lvgi',
        'tata',
        'beneish_m_score'
    ];

    /**
     * Relasi ke model Company (setiap FraudAnalysis berhubungan dengan satu Company)
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Relasi ke model HorizontalAnalysis (setiap FraudAnalysis berhubungan dengan satu HorizontalAnalysis)
     */
    public function horizontalAnalysis()
    {
        return $this->belongsTo(HorizontalAnalysis::class);
    }
}
