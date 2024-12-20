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
        Schema::create('precios', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_cabania')->unsigned()->nullable();
            $table->date('fecha_desde')->nullable();
            $table->date('fecha_hasta')->nullable();
            $table->string('valor')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });


            Schema::table('precios', function (Blueprint $table) {
                $table->foreign('id_cabania')->references('id')->on('cabanias')
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
        Schema::dropIfExists('precios');
    }
};
