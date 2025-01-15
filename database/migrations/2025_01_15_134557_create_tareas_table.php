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
        Schema::create('tareas', function (Blueprint $table) {
                $table->increments('id');
                $table->string('denominacion')->nullable();
                $table->string('descripcion')->nullable();
                $table->date('fecha')->nullable();
                $table->integer('id_estado_tarea')->nullable();
                $table->string('prioridad')->nullable();
                $table->integer('id_usuario')->unsigned()->nullable();
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
        Schema::dropIfExists('tareas');
    }
};
