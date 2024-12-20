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
        Schema::table('cabanias', function (Blueprint $table) {            
            $table->text('observaciones', 1000)->nullable()->after('capacidad');
        });

        Schema::table('clientes', function (Blueprint $table) {            
            $table->text('observaciones', 1000)->change();
        });

        Schema::table('reservas', function (Blueprint $table) {            
            $table->text('observaciones', 1000)->change();
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
        Schema::table('cabanias', function (Blueprint $table) {
            $table->dropColumn('observacion');
        });

        Schema::table('clientes', function (Blueprint $table) {            
            $table->string('observaciones')->change() ;
        });

        Schema::table('reservas', function (Blueprint $table) {            
            $table->string('observaciones')->change();
        });
    }
};
