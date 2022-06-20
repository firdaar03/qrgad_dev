<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateVwCompareInexCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement(
            'CREATE OR REPLACE VIEW vw_compare_inex_car AS SELECT
            k.kategori, 
            COUNT(t.id) as total_trip
            FROM
            tb_trips t INNER JOIN ms_kendaraans k ON t.kendaraan = k.id
            GROUP BY
            k.kategori' 
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
