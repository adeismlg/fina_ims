<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFraudAnalysesTable extends Migration
{
    /**
     * Jalankan migration.
     */
    public function up()
    {
        Schema::create('fraud_analyses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('horizontal_analysis_id')->nullable(); // Nama kolom yang benar
            $table->unsignedBigInteger('financial_data_id')->nullable();
            $table->integer('year');
            $table->decimal('dsri', 15, 6)->nullable();
            $table->decimal('gmi', 15, 6)->nullable();
            $table->decimal('aqi', 15, 6)->nullable();
            $table->decimal('sgi', 15, 6)->nullable();
            $table->decimal('depi', 15, 6)->nullable();
            $table->decimal('sgai', 15, 6)->nullable();
            $table->decimal('lvgi', 15, 6)->nullable();
            $table->decimal('tata', 15, 6)->nullable();
            $table->decimal('beneish_m_score', 15, 6)->nullable();
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('horizontal_analysis_id')->references('id')->on('horizontal_analyses')->onDelete('set null'); // Nama tabel dan kolom yang benar
            $table->foreign('financial_data_id')->references('id')->on('financial_data')->onDelete('set null');
        });
    }

    /**
     * Rollback migration.
     */
    public function down()
    {
        Schema::dropIfExists('fraud_analyses'); // Nama tabel yang benar
    }
}
