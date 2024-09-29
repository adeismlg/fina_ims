<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinancialDistressesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('financial_distresses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->year('year');
            $table->decimal('current_ratio', 15, 6)->nullable(); // Likuiditas
            $table->decimal('debt_to_asset_ratio', 15, 6)->nullable(); // Leverage
            $table->decimal('return_on_assets', 15, 6)->nullable(); // Profitabilitas
            $table->decimal('z_score', 15, 6)->nullable(); // Z-Score
            $table->string('classification')->nullable(); // Klasifikasi Z-Score
            $table->timestamps();

            // Foreign key untuk relasi dengan tabel companies
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('financial_distresses');
    }
}
