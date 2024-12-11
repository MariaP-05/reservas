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
        Schema::create('caracteristicas_cab', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_cabania')->unsigned()->nullable();
            $table->integer('id_caracteristica')->unsigned()->nullable();
            $table->string('cantidad')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
            Schema::table('caracteristicas_cab', function (Blueprint $table) {
                $table->foreign('id_cabania')->references('id')->on('cabanias')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');
            });

            Schema::table('caracteristicas_cab', function (Blueprint $table) {
                $table->foreign('id_caracteristica')->references('id')->on('caracteristicas')
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
        Schema::dropIfExists('caracteristicas_cab');
    }
};
