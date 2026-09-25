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
        Schema::create('comprobantes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('numero')->nullable();
            $table->date('fecha_vencimiento_cae')->nullable();
            $table->string('numero_cae')->nullable();
            $table->integer('punto_venta')->nullable();
            $table->integer('id_reserva')->unsigned()->nullable();
            $table->foreign('id_reserva')->references('id')->on('reservas')
                ->onDelete('restrict')
                ->onUpdate('cascade');
            $table->text('observaciones');
            $table->date('fecha')->nullable();
            $table->integer('id_tipo_comprobante')->unsigned()->nullable();
            $table->integer('id_estado_comprobante')->unsigned()->nullable();
            $table->decimal('valor', 11, 2)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('tipos_comprobantes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('codigo')->nullable();
            $table->string('denominacion')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('estados_comprobantes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('denominacion')->nullable();
            $table->string('icono')->nullable();
            $table->string('color')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('comprobantes', function (Blueprint $table) {
            $table->foreign('id_tipo_comprobante')->references('id')->on('tipos_comprobantes')
                ->onDelete('restrict')
                ->onUpdate('cascade');
        });

        Schema::table('comprobantes', function (Blueprint $table) {
            $table->foreign('id_estado_comprobante')->references('id')->on('estados_comprobantes')
                ->onDelete('restrict')
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
        Schema::dropIfExists('comprobantes');
        Schema::dropIfExists('estados_comprobantes');
        Schema::dropIfExists('tipos_comprobantes');
    }
};
