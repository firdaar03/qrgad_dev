<?php

namespace App\Models\Table\Qrgad;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TbTripRequest extends Model
{
    use HasFactory;

    protected $connection = 'mysql9';
    protected $table = 'tb_trip_requests';

    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        "id",
        "jenis_perjalanan",
        "tujuan",
        "pemohon",
        "wilayah",
        "agenda",
        "waktu_berangkat",
        "waktu_pulang",
        "penumpang",
        "count_people",
        "keterangan",
        "departemen",
        "input_time",
        "approve_time",
        "approve_by",
        "response_time",
        "close_time",
        "status",
    ];
    
    public static function idOtomatis()
    {
        $kode = DB::table('tb_trip_requests')->max('id');
    	$addNol = '';
    	$kode = str_replace("TR", "", $kode);
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

    	$kodeBaru = "TR".$addNol.$incrementKode;
    	return $kodeBaru;
    }
}
