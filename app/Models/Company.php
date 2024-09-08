<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'address', 'email'];

    /**
     * Relasi ke FinancialData (one-to-many).
     */
    public function financialData()
    {
        return $this->hasMany(FinancialData::class);
    }

    /**
     * Relasi ke FraudAnalysis (one-to-many).
     */
    public function fraudAnalyses()
    {
        return $this->hasMany(FraudAnalysis::class);
    }

    /**
     * Relasi ke HorizontalAnalysis (one-to-many).
     */
    public function horizontalAnalyses()
    {
        return $this->hasMany(HorizontalAnalysis::class);
    }
}
