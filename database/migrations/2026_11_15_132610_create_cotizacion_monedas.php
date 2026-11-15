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
        Schema::create('cotizaciones_moneda', function (Blueprint $table) {
          $table->increments('id');
            $table->decimal('usd', 10, 2);
            $table->date('fecha');
            $table->timestamps();
            $table->softDeletes();
        });

           Schema::table('comprobantes', function (Blueprint $table) {
             $table->integer('id_cotizacion_moneda')->unsigned()->nullable()->after('id_estado_comprobante');
             $table->foreign('id_cotizacion_moneda')->references('id')->on('cotizaciones_moneda')->onDelete('restrict')
                ->onUpdate('cascade');           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      
            Schema::table('comprobantes', function (Blueprint $table) {
                $table->dropForeign(['id_cotizacion_moneda']);
                $table->dropColumn('id_cotizacion_moneda');
            });
              Schema::dropIfExists('cotizaciones_moneda');
    }
};
