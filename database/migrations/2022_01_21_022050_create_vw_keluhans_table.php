<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateVwKeluhansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement(
            'CREATE OR REPLACE VIEW vw_keluhans AS SELECT
			k.id,
            k.keluhan,
            k.aset,
            k.non_aset,
            lm.nama as lokasi,
            k.detail_lokasi,
            k.pelapor as username,
            u.nama as pelapor,
            k.input_time,
            k.respon_time,
            k.close_time,
            k.grup,
            rk.info_respon,
            rk.responden as username_responden,
            us.nama as responden,
            rk.solusi,
            rk.biaya,
            rk.kategori,
            k.status
            FROM
            tb_keluhans k INNER JOIN ms_lokasi_maintains lm ON k.lokasi = lm.id INNER JOIN users u ON k.pelapor = u.username LEFT JOIN tb_respon_keluhans rk ON k.id = rk.keluhan LEFT JOIN users us ON rk.responden = us.username
            '
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
