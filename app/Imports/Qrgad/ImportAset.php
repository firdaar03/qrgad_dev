<?php

namespace App\Imports\Qrgad;

use App\Models\Table\Qrgad\TbAset;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ImportAset implements ToModel, WithStartRow
{
    public function startRow(): int
    {
        return 2;
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function model(array $row)
    {
        DB::table('tb_asets')->insertGetId([
            'code_asset' => $row[0],
            'deskripsi' => $row[1],
            'id' => TbAset::idOtomatis(),
        ]);
        
    }
}
