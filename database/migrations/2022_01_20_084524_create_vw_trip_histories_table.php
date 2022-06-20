<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateVwTripHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
            CREATE OR REPLACE VIEW vw_trip_history
            AS
            SELECT t.id, 
            k.nama AS nama_kendaraan, 
            s.nama AS nama_supir, 
            tr.waktu_berangkat AS wb_plan, 
            tr.waktu_pulang AS wp_plan, 
            th.waktu_berangkat AS wb_actual, 
            th.waktu_pulang AS wp_actual, 
            th.kilometer_berangkat, 
            th.kilometer_pulang, 
            tr.status 
            FROM tb_trip_requests tr 
            INNER JOIN tb_trips t ON tr.id = t.trip_request 
            INNER JOIN ms_kendaraans k ON t.kendaraan = k.id 
            INNER JOIN tb_trip_historis th ON th.trip = t.id 
            INNER JOIN ms_supirs s ON t.supir = s.id
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vw_trip_histories');
    }
}
