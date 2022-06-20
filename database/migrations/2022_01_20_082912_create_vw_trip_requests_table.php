<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateVwTripRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
            CREATE OR REPLACE VIEW vw_trip_requests
            AS
            SELECT t.id AS kode_trip_requests, 
            tr.id AS kode_trip, 
            u.nama AS pemohon, 
            tr.jenis_perjalanan, 
            tr.tujuan, 
            tr.waktu_berangkat, 
            tr.waktu_pulang, 
            tr.input_time, 
            tr.approve_time, 
            tr.response_time, 
            tr.status 
            FROM tb_trip_requests tr 
            INNER JOIN tb_trips t ON tr.id = t.trip_request 
            INNER JOIN users u ON tr.pemohon = u.nama
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
