<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateVwMostTraveledDriversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
            CREATE OR REPLACE VIEW vw_most_traveled_drivers
            AS
            SELECT 
            s.nama AS supir, 
            COUNT(t.supir) AS total_perjalanan
            FROM tb_trips t 
            INNER JOIN ms_supirs s ON t.supir = s.id 
            GROUP BY s.nama ORDER BY total_perjalanan DESC;
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
