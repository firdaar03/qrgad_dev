<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateVwMostTraveledDeptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
            CREATE OR REPLACE VIEW vw_most_traveled_depts
            AS
            SELECT 
            tr.departemen, 
            COUNT(tr.departemen) AS total_perjalanan
            FROM tb_trips t 
            INNER JOIN tb_trip_requests tr ON t.trip_request = tr.id 
            GROUP BY tr.departemen ORDER BY total_perjalanan DESC;
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
