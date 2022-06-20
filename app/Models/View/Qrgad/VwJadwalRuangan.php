<?php

namespace App\Models\View\Qrgad;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class VwJadwalRuangan extends Model
{
    use HasFactory;
    protected $connection = 'mysql9';
    protected $table ='vw_jadwal_ruangans';
    public $incrementing = false;

    public static function getByDate($date){
        $jadwals = DB::select("SELECT * FROM `vw_jadwal_ruangans` WHERE start like '".$date."%' OR end like '".$date."%'");
        return $jadwals;
    }
}
