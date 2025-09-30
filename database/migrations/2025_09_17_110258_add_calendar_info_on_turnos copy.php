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
        //
        Schema::table('reservas', function (Blueprint $table) {
            $table->string('start')->nullable()->after('id_cliente');
            $table->string('end')->nullable()->after('start');
           $table->string('allDay')->nullable()->after('end');
            $table->string('title')->nullable()->after('end');
            $table->string('backgroundColor')->nullable()->after('title');
          $table->string('borderColor')->nullable()->after('backgroundColor');
           $table->string('textColor')->nullable()->after('borderColor');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
          Schema::table('turnos', function (Blueprint $table) {
            $table->dropColumn('start');
            $table->dropColumn('end');
           // $table->dropColumn('allDay');
            $table->dropColumn('title');
            $table->dropColumn('backgroundColor');
            $table->dropColumn('borderColor');
            $table->dropColumn('textColor');
        });
           
    }
};
