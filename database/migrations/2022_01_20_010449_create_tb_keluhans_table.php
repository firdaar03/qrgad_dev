<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateTbKeluhansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_keluhans', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('keluhan');
            $table->string('aset');
            $table->string('non_aset');
            $table->string('lokasi');
            $table->string('detail_lokasi');
            $table->string('pelapor');
            $table->date('input_time');
            $table->date('respon_time')->nullable();
            $table->date('close_time')->nullable();
            $table->integer('status');
            $table->foreignId('grup');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_keluhans');
    }
}
