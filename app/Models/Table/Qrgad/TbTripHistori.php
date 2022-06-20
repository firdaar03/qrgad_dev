<?php

namespace App\Models\Table\Qrgad;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TbTripHistori extends Model
{
    use HasFactory;

    protected $connection = 'mysql9';
    protected $table = 'tb_trip_historis';

    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        "id",
        "trip",
        "kilometer_berangkat",
        "waktu_berangkat",
        "kilometer_pulang",
        "waktu_pulang",
        "penumpang",
        "kilometer_total",
    ];
    
    public static function idOtomatis()
    {
        $kode = DB::table('tb_trip_historis')->max('id');
    	$addNol = '';
    	$kode = str_replace("TH", "", $kode);
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

    	$kodeBaru = "TH".$addNol.$incrementKode;
    	return $kodeBaru;
    }
}
