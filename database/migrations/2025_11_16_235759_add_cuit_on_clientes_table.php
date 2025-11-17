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
          Schema::table('clientes', function (Blueprint $table) {
            $table->string('cuit', 20)->nullable()->after('observaciones');
            $table->string('razon_social', 100)->nullable()->after('cuit');
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
            Schema::table('clientes', function (Blueprint $table) {
                $table->dropColumn('cuit');
                $table->dropColumn('razon_social');
            });
    }
};
