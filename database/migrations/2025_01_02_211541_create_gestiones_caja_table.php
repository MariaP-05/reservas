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
        Schema::create('gestiones_caja', function (Blueprint $table) {
            $table->increments('id');
            $table->string('denominacion')->nullable();
            $table->date('fecha')->nullable();
            $table->string('importe')->nullable();
            $table->integer('id_tipo_movimiento')->unsigned()->nullable();
            $table->integer('id_categoria')->unsigned()->nullable();
            $table->integer('id_usuario')->unsigned()->nullable();
            $table->string('forma_pago')->nullable();
            $table->string('observaciones')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gestiones_caja');
    }
};
