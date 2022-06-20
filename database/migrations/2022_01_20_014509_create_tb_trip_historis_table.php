<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbTripHistorisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_trip_historis', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('trip');
            $table->bigInteger('kilometer_berangkat');
            $table->date('waktu_berangkat');
            $table->bigInteger('kilometer_pulang');
            $table->date('waktu_pulang');
            $table->text('penumpang');
            $table->bigInteger('kilometer_total');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_trip_historis');
    }
}
