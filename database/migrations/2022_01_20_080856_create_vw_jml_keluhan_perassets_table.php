<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateVwJmlKeluhanPerassetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement(
            'CREATE OR REPLACE VIEW vw_jml_keluhan_perassets AS SELECT
            k.aset,
            COUNT(k.id) AS `total_keluhan` 
          
            FROM
                tb_keluhans k
            
            GROUP BY 
                k.aset
            
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
