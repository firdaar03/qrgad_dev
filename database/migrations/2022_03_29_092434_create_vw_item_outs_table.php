<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateVwItemOutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement(
            'CREATE OR REPLACE VIEW vw_item_outs AS SELECT
            i.id,
            i.keluhan,
            k.nama AS konsumable,
            i.jumlah,
            i.date_item_out,
            i.username,
            u.nama
            FROM tb_item_outs i INNER JOIN tb_konsumables k ON i.konsumable = k.id INNER JOIN users u ON i.username = u.username'
        );

        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vw_item_outs');
    }
}
