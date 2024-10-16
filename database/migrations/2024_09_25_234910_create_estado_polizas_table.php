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
       
        Schema::create('estado_polizas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('denominacion')->nullable();
            $table->string('icono')->nullable();
            $table->string('color')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });


        Schema::table('polizas', function (Blueprint $table) {
            $table->integer('id_estado_polizas')->unsigned()->nullable()->after ('numero_poliza');
        });
       
        Schema::table('polizas', function (Blueprint $table) {
            $table->foreign('id_estado_polizas')->references('id')->on('estado_polizas')
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
       
        Schema::dropIfExists('estado_polizas');
    
    }
};
