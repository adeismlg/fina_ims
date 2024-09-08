<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateColumnsInFraudAnalysesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fraud_analyses', function (Blueprint $table) {
            // Mengubah tipe data ke double untuk menangani nilai yang besar
            $table->double('sgi', 15, 8)->change();
            $table->double('dsri', 15, 8)->change();
            $table->double('gmi', 15, 8)->change();
            $table->double('aqi', 15, 8)->change();
            $table->double('depi', 15, 8)->change();
            $table->double('sgai', 15, 8)->change();
            $table->double('lvgi', 15, 8)->change();
            $table->double('tata', 15, 8)->change();
            $table->double('beneish_m_score', 15, 8)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fraud_analyses', function (Blueprint $table) {
            // Kembalikan ke float jika diperlukan
            $table->float('sgi')->change();
            $table->float('dsri')->change();
            $table->float('gmi')->change();
            $table->float('aqi')->change();
            $table->float('depi')->change();
            $table->float('sgai')->change();
            $table->float('lvgi')->change();
            $table->float('tata')->change();
            $table->float('beneish_m_score')->change();
        });
    }
}
