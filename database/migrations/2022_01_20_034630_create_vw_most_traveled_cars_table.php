<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateVwMostTraveledCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
            CREATE OR REPLACE VIEW vw_most_traveled_cars
            AS
            SELECT 
            k.nama, 
            k.nopol, 
            th.kilometer_total 
            FROM 
            tb_trips t 
            INNER JOIN ms_kendaraans k ON t.kendaraan = k.id 
            INNER JOIN tb_trip_historis th ON t.id = th.trip;
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       
    }
}
