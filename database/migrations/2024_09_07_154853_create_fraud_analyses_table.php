<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFraudAnalysesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fraud_analyses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->foreignId('horizontal_analysis_id')->constrained()->onDelete('cascade'); // Foreign key ke tabel horizontal_analyses
            $table->integer('year');
            $table->double('dsri', 15, 8)->nullable();
            $table->double('gmi', 15, 8)->nullable();
            $table->double('aqi', 15, 8)->nullable();
            $table->double('sgi', 15, 8)->nullable();
            $table->double('depi', 15, 8)->nullable();
            $table->double('sgai', 15, 8)->nullable();
            $table->double('lvgi', 15, 8)->nullable();
            $table->double('tata', 15, 8)->nullable();
            $table->double('beneish_m_score', 15, 8)->nullable();
            $table->timestamps();
        });        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fraud_analyses');
    }
}
