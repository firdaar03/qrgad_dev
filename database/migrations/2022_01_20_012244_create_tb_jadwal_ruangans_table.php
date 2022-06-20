<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateTbJadwalRuangansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_jadwal_ruangans', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('ruangan');
            $table->string('peminjam');
            $table->string('perusahaan');
            $table->text('agenda');
            $table->text('kebutuhan')->nullable();
            $table->dateTime('start');
            $table->dateTime('end');
            $table->timestamp('created_at')->default(DB::raw("CURRENT_TIMESTAMP"));
            $table->string('color');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_jadwal_ruangans');
    }
}
