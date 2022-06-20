<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateVwTabelInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vw_tabel_inventoris', function (Blueprint $table) {
            DB::statement(
                "CREATE OR REPLACE VIEW vw_tabel_inventoris AS SELECT 
                K.id AS id_konsumable, 
                K.nama AS nama_konsumable, 
                K.jenis_satuan AS satuan, 
                SUM(I.jumlah_stock ) AS stock, 
                KK.nama AS kategori_konsumable, 
                SKK.nama AS sub_kategori_konsumable, 
                I.date_in AS last_entry, 
                K.code_group AS code_group,
                K.minimal_stock AS minimal_stock
                FROM tb_inventoris I RIGHT JOIN tb_konsumables K ON I.konsumable = K.id 
                JOIN ms_kategori_konsumables KK ON K.kategori_konsumable = KK.id 
                JOIN ms_sub_kategori_konsumables SKK ON K.sub_kategori_konsumable = SKK.id 
                GROUP BY K.id
                ORDER BY K.id ASC;"
            );
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vw_tabel_inventories');
    }
}
