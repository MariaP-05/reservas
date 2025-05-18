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
       /*
        Schema::create('historial_observaciones', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_tarea')->unsigned()->nullable();
            $table->integer('id_usuario')->unsigned()->nullable();
            $table->text('observaciones');
            $table->date('fecha')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('historial_observaciones', function (Blueprint $table) {
            $table->foreign('id_tarea')->references('id')->on('tareas')
                ->onDelete('restrict')
                ->onUpdate('cascade');  
        });

        */
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('historial_observaciones');
    }
};
