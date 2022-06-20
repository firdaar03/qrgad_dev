<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbResponKeluhansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_respon_keluhans', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('keluhan');
            $table->string('responden');
            $table->string('info_respon');
            $table->string('solusi');
            $table->integer('biaya');
            $table->integer('kategori');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_respon_keluhans');
    }
}
