<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class VwDtRuangans extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement(
            'CREATE OR REPLACE VIEW vw_dt_ruangans AS SELECT 
            dr.ruangan AS ruangan, 
            f.nama AS fasilitas 
            FROM dt_ruangans dr 
            INNER JOIN ms_fasilitas_ruangans f 
            ON dr.fasilitas = f.id' 
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
