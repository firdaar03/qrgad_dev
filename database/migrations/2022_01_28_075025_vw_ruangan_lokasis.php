<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class VwRuanganLokasis extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement(
            'CREATE OR REPLACE VIEW vw_ruangan_lokasis AS SELECT 
            r.id AS id_ruang, 
            r.nama as nama_ruang, 
            l.nama as nama_lokasi, 
            r.lantai as lantai, 
            r.kapasitas AS kapasitas, 
            r.lokasi AS id_lokasi 
            FROM ms_ruangans r 
            INNER JOIN ms_lokasis l 
            ON r.lokasi = l.id 
            WHERE r.status = 1 
            ORDER BY r.id ASC' 
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
