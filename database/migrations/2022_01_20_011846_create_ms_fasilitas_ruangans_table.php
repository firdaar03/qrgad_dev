<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateMsFasilitasRuangansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ms_fasilitas_ruangans', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('nama');
            $table->integer('status');
            $table->timestamp('created_at')->default(DB::raw("CURRENT_TIMESTAMP"));
            $table->string('created_by');
            $table->timestamp('updated_at')->default(DB::raw("CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP"))->nullable();
            $table->string('updated_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ms_fasilitas_ruangans');
    }
}
