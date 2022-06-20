<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbTripRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_trip_requests', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->integer('jenis_perjalanan');
            $table->string('tujuan');
            $table->string('pemohon');
            $table->string('wilayah');
            $table->string('agenda');
            $table->date('waktu_berangkat');
            $table->date('waktu_pulang');
            $table->text('penumpang')->nullable();
            $table->integer('count_people')->nullable();
            $table->text('keterangan')->nullable();
            $table->text('departemen');
            $table->date('input_time');
            $table->date('approve_time')->nullable();
            $table->string('approve_by')->nullable();
            $table->date('response_time')->nullable();
            $table->date('close_time')->nullable();
            $table->integer('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_trip_requests');
    }
}
