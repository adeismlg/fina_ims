<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinancialDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('financial_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onDelete('cascade'); // Foreign key to companies table
            $table->year('year'); // Menyimpan tahun data keuangan
            $table->bigInteger('sales')->nullable();
            $table->bigInteger('cost_of_goods_sold')->nullable();
            $table->bigInteger('current_assets')->nullable();
            $table->bigInteger('plant_property_equipment')->nullable();
            $table->bigInteger('sga_expenses')->nullable();
            $table->bigInteger('total_assets')->nullable();
            $table->bigInteger('depreciation')->nullable();
            $table->bigInteger('account_receivables')->nullable();
            $table->bigInteger('long_term_debt')->nullable();
            $table->bigInteger('current_liabilities')->nullable();
            $table->bigInteger('working_capital')->nullable();
            $table->bigInteger('cash')->nullable();
            $table->bigInteger('current_taxes_payables')->nullable();
            $table->bigInteger('depreciation_amortization')->nullable();
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
        Schema::dropIfExists('financial_data');
    }
}
