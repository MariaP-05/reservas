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
        Schema::create('prestadores', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre')->nullable();
            $table->string('razon_social')->nullable();
            $table->string('domicilio')->nullable();
            $table->string('cuit')->nullable();
            $table->string('cert')->nullable();
            $table->string('key')->nullable();
            $table->string('token')->nullable();
            $table->integer('iva')->nullable();
            $table->string('iva_denominacion')->nullable();
            $table->date('fecha_inicio_actividad')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });

          Schema::table('comprobantes', function (Blueprint $table) {
             $table->integer('id_prestador')->unsigned()->nullable()->after('id_estado_comprobante');
             $table->foreign('id_prestador')->references('id')->on('prestadores')->onDelete('restrict')
                ->onUpdate('cascade');           
        });

        Schema::table('reservas', function (Blueprint $table) {
             $table->integer('id_prestador')->unsigned()->nullable()->after('motivos_recargos');
             $table->foreign('id_prestador')->references('id')->on('prestadores')->onDelete('restrict')
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
        Schema::dropIfExists('prestadores');
          Schema::table('reservas', function (Blueprint $table) {
            $table->dropColumn('id_prestador');
        });
    
      Schema::table('comprobantes', function (Blueprint $table) {
            $table->dropColumn('id_prestador');
        });
    
    }
};
