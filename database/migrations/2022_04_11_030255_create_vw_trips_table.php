<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateVwTripsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
        CREATE OR REPLACE VIEW vw_trips AS SELECT 
            tr.id as id_trip_request,
            t.id as id_trip,
            th.id as id_trip_histori,
            tr.jenis_perjalanan,
            tr.tujuan,
            u.username,
            u.nama as pemohon,
            tr.departemen,
            tr.wilayah,
            tr.keperluan,
            tr.waktu_berangkat,
            tr.waktu_pulang,
            tr.penumpang,
            tr.count_people,
            tr.keterangan,
            tr.input_time,
            tr.approve_time,
            us.nama as approve_by,
            tr.approve_by as approve_by_username,
            tr.reject_time,
            ur.nama as reject_by,
            tr.reject_by as reject_by_username,
            tr.response_time,
            tr.set_trip_time,
            tr.close_time,
            k.nama as kendaraan,
            k.id as kendaraan_id,
            k.nopol,
            s.nama as supir,
            t.departure_time,
            th.waktu_berangkat as waktu_berangkat_aktual,
            th.waktu_pulang as waktu_pulang_aktual,
            th.penumpang as penumpang_aktual,
            th.kilometer_berangkat,
            th.kilometer_pulang,
            th.kilometer_total,
            tr.status
            FROM tb_trip_requests tr 
            INNER JOIN users u ON u.username = tr.pemohon
            LEFT JOIN users us ON tr.approve_by = us.username
            LEFT JOIN users ur ON tr.reject_by = ur.username
            LEFT JOIN tb_trips t ON t.trip_request = tr.id
            LEFT JOIN ms_supirs s ON s.id = t.supir
            LEFT JOIN ms_kendaraans k ON k.id = t.kendaraan
            LEFT JOIN tb_trip_historis th ON th.trip = t.id
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vw_trips');
    }
}
