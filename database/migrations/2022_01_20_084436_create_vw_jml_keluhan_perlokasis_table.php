<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateVwJmlKeluhanPerlokasisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement(
            'CREATE OR REPLACE VIEW vw_jml_keluhan_perlokasis AS SELECT
            lm.nama,
            COUNT(k.id) AS `total_keluhan` 
          
            FROM
                tb_keluhans k INNER JOIN ms_lokasi_maintains lm ON k.lokasi = lm.id
            
            GROUP BY 
                lm.nama
            
            ORDER BY 
                `total_keluhan` DESC'
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
