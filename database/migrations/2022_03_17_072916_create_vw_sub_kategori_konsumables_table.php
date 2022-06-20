<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateVwSubKategoriKonsumablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vw_sub_kategori_konsumables', function (Blueprint $table) {
            DB::statement(
                "CREATE OR REPLACE VIEW vw_sub_kategori_konsumables AS SELECT 
                SK.id,
                SK.kategori_konsumable AS id_kategori_konsumable,
                KK.nama AS kategori_konsumable,
                sk.nama,
                SK.status
                FROM 
                ms_sub_kategori_konsumables SK INNER JOIN ms_kategori_konsumables KK ON SK.kategori_konsumable = KK.id"
            );
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vw_sub_kategori_konsumables');
    }
}
