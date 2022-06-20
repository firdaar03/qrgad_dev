<?php

namespace App\Exports\Qrgad;

use App\Models\Table\Qrgad\TbAset;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportAset implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return TbAset::select('code_asset','deskripsi')->where('id', 'AS00000001')->get();
    }

    public function headings(): array
    {
        return [
            ["kode aset", "deskripsi"],
            ["13131481", "PC DELL"]
        ];
    }
}
