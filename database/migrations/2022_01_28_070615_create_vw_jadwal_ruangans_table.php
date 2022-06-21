<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateVwJadwalRuangansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement(
            "CREATE OR REPLACE VIEW vw_jadwal_ruangans AS SELECT 
            jr.id,
            r.nama as ruangan,
            r.id as id_ruangan,
            u.username as username,
            u.nama as peminjam,
            u.divisi,
            p.nama as perusahaan, 
            jr.agenda,
            jr.start,
            jr.end,
            jr.color,
            jr.created_at
            FROM 
            tb_jadwal_ruangans jr INNER JOIN ms_ruangans r ON jr.ruangan = r.id 
            INNER JOIN ms_perusahaans p ON jr.perusahaan = p.id 
            INNER JOIN users u ON jr.peminjam = u.username"
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
