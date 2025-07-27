<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
           Schema::table('movimientos', function (Blueprint $table) {
            $table->string('moneda')->nullable()->after('forma_pago')->default('Pesos');
        });

         Schema::table('reservas', function (Blueprint $table) {
            $table->string('moneda')->nullable()->after('valor')->default('Pesos');
        });

           Schema::table('precios', function (Blueprint $table) {
            $table->string('valor_dolar')->nullable()->after('valor')->default('0');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
           Schema::table('movimientos', function (Blueprint $table) {
            $table->dropColumn('moneda');
        });
           Schema::table('reservas', function (Blueprint $table) {
            $table->dropColumn('moneda');
        });
           Schema::table('precios', function (Blueprint $table) {
            $table->dropColumn('valor_dolar');
        });
    }
};
