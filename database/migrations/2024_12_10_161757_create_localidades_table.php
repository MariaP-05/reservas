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
        //provincias
        Schema::create('provincias', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre')->unique()->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        //localidades
        Schema::create('localidades', function (Blueprint $table) {
            $table->increments('id');            
            $table->string('denominacion')->nullable();
            $table->string('cod_postal', 50)->unique()->nullable();          
            $table->integer('provincia_id')->unsigned()->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('localidades', function (Blueprint $table) {
            $table->foreign('provincia_id')->references('id')->on('provincias')
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
       
        Schema::dropIfExists('localidades');
        Schema::dropIfExists('provincias');
    
    }
};
