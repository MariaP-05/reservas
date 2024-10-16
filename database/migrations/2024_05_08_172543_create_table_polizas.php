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
        Schema::create('polizas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_compania')->unsigned()->nullable();
            $table->integer('id_cliente')->unsigned()->nullable();
            $table->integer('id_seccion')->unsigned()->nullable();
            $table->string('numero_poliza')->nullable();
            $table->date('vigencia_desde')->nullable();
            $table->date('vigencia_hasta')->nullable();
            $table->string('vehiculo')->nullable();
            $table->string('marca')->nullable();
            $table->integer('id_forma_pago')->unsigned()->nullable();
            $table->string('cantidad_cuotas')->nullable();
            $table->integer('id_productor')->unsigned()->nullable();
            $table->string('cobertura')->nullable();
            $table->timestamps();
            $table->softDeletes();
                });

            Schema::table('polizas', function (Blueprint $table) {
                    $table->foreign('id_compania')->references('id')->on('companias')
                        ->onDelete('restrict')
                        ->onUpdate('cascade');  
            });

            Schema::table('polizas', function (Blueprint $table) {
                $table->foreign('id_cliente')->references('id')->on('clientes')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');  
            });

            Schema::table('polizas', function (Blueprint $table) {
                $table->foreign('id_seccion')->references('id')->on('secciones')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');  
            });

            Schema::table('polizas', function (Blueprint $table) {
                $table->foreign('id_forma_pago')->references('id')->on('formas_pago')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');  
            });

            Schema::table('polizas', function (Blueprint $table) {
                $table->foreign('id_productor')->references('id')->on('productores')
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
        Schema::dropIfExists('polizas');
    }
};
