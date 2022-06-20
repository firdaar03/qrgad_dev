<?php

namespace App\Models\Table\Qrgad;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TbJadwalRuangan extends Model
{
    use HasFactory;
    protected $connection = 'mysql9';
    protected $table = 'tb_jadwal_ruangans';

    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'agenda',
        'peminjam',
        'perusahaan',
        'ruangan',
        'start',
        'end',
        'kebutuhan',
        'color'
    ];

    public static function idOtomatis()
    {
        $kode = TbJadwalRuangan::max('id');
    	$addNol = '';
    	$kode = str_replace("JR", "", $kode);
    	$kode = (int) $kode + 1;
        $incrementKode = $kode;

    	if (strlen($kode) == 1) {
    		$addNol = "0000000";
    	} elseif (strlen($kode) == 2) {
    		$addNol = "000000";
    	} elseif (strlen($kode == 3)) {
    		$addNol = "00000";
    	} elseif (strlen($kode == 4)) {
    		$addNol = "0000";
    	} elseif (strlen($kode == 5)) {
    		$addNol = "000";
    	} elseif (strlen($kode == 6)) {
    		$addNol = "00";
    	} elseif (strlen($kode == 7)) {
    		$addNol = "0";
    	} else {
            $addNol = "";
        }

    	$kodeBaru = "JR".$addNol.$incrementKode;
    	return $kodeBaru;
    }

    public static function dateCheck($start, $end){
        $jadwals = TbJadwalRuangan::all();
        $isValid = false;

        foreach($jadwals as $j){
            if(
                ($start >= $j->start && $start <= $j->end)  // start_input nya berada di antara start dan end yang sudah ada
                //or ($end >= $j->start and $end <= $j->end) // end_input nya berada di antara start dan end yang sudah ada
                //or ($start <= $j->start and $end >= $j->end) // start_input melebihi start yang ada dan end_input melebihi end yang ada
                
                ){
                    $isValid = true;
                    break;

                    dd("start_input ".$start." start_db ".$j->start." end_db ".$j->end);
            } else {
                $isValid = false;
            }
        }

        return $isValid;
    }

    // public static function getByIdDate($id, $start, $end){
    //     $list = DB::select("SELECT * FROM `vw_jadwal_ruangans` WHERE id_ruangan = '".$id."' AND start >='".$start."' AND end <= '".$end."'");
    //     return $list;
    // }
    
}
