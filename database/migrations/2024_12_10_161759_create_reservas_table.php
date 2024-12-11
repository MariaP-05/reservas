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
        Schema::create('reservas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_cabania')->unsigned()->nullable();
            $table->integer('id_cliente')->unsigned()->nullable();
            $table->integer('id_forma_pago')->unsigned()->nullable();
            $table->integer('id_estado_reserva')->unsigned()->nullable();
            $table->date('fecha_desde')->nullable();
            $table->date('fecha_hasta')->nullable();
            $table->string('hora_ingreso')->nullable();
            $table->string('hora_egreso')->nullable();
            $table->string('senia')->nullable();
            $table->string('descuento')->nullable();
            $table->string('cantidad_personas')->nullable();
            $table->string('observaciones')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });


        Schema::table('reservas', function (Blueprint $table) {
            $table->foreign('id_cabania')->references('id')->on('cabanias')
                ->onDelete('restrict')
                ->onUpdate('cascade');
        });

        Schema::table('reservas', function (Blueprint $table) {
            $table->foreign('id_cliente')->references('id')->on('clientes')
                ->onDelete('restrict')
                ->onUpdate('cascade');
        });

        Schema::table('reservas', function (Blueprint $table) {
            $table->foreign('id_forma_pago')->references('id')->on('formas_pago')
                ->onDelete('restrict')
                ->onUpdate('cascade');  
        });

        Schema::table('reservas', function (Blueprint $table) {
            $table->foreign('id_estado_reserva')->references('id')->on('estados_reserva')
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
        Schema::dropIfExists('reservas');
    }
};
