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
        Schema::table('reservas', function (Blueprint $table) {            
            $table->decimal('recargo',11,2)->nullable()->after('descuento');
            $table->decimal('valor',11,2)->nullable()->after('recargo');
        });

        Schema::table('precios', function (Blueprint $table) {            
            $table->decimal('valor',11,2)->change() ;
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
        Schema::table('reservas', function (Blueprint $table) {
            $table->dropColumn('recargo');
            $table->dropColumn('valor');
        });
    }
};
