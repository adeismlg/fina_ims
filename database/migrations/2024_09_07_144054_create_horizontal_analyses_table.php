<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHorizontalAnalysesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('horizontal_analyses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->year('year');  // Tahun yang dipilih
            $table->year('previous_year')->nullable();  // Tahun sebelumnya

            // Kolom untuk menyimpan perbedaan (difference) dari setiap item keuangan
            $table->bigInteger('sales_difference')->nullable();
            $table->bigInteger('cost_of_goods_sold_difference')->nullable();
            $table->bigInteger('current_assets_difference')->nullable();
            $table->bigInteger('plant_property_equipment_difference')->nullable();
            $table->bigInteger('sga_expenses_difference')->nullable();
            $table->bigInteger('total_assets_difference')->nullable();
            $table->bigInteger('depreciation_difference')->nullable();
            $table->bigInteger('account_receivables_difference')->nullable();
            $table->bigInteger('long_term_debt_difference')->nullable();
            $table->bigInteger('current_liabilities_difference')->nullable();
            $table->bigInteger('working_capital_difference')->nullable();
            $table->bigInteger('cash_difference')->nullable();
            $table->bigInteger('current_taxes_payables_difference')->nullable();
            $table->bigInteger('depreciation_amortization_difference')->nullable();

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
        Schema::dropIfExists('horizontal_analyses');
    }
}
