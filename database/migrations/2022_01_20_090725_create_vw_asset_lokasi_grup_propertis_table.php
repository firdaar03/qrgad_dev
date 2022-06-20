<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateVwAssetLokasiGrupPropertisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement(
            'CREATE OR REPLACE VIEW vw_asset_lokasi_grup_propertis AS SELECT 
            a.id, 
            a.kode_aset, 
            a.deskripsi, 
            a.kondisi, 
            p.nama as properti, 
            l.nama as lokasi, 
            g.nama as grup, 
            a.keterangan, 
            a.created_at, 
            a.created_by, 
            a.updated_at, 
            a.updated_by
            FROM 
            ms_asets a INNER JOIN ms_lokasis l ON a.lokasi = l.id INNER JOIN ms_grup_asets g ON g.id = a.grup INNER JOIN ms_properti_asets p ON p.id = a.properti'
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
