<?php

namespace App\Models\Table\Qrgad;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MsFasilitasRuangan extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $connection = 'mysql9';
    protected $table = 'ms_fasilitas_ruangans';

    protected $fillable = [
        'id',
        'nama',
        'created_by',
        'updated_by',
        'status'       
    ];

    public static function idOtomatis()
    {
        $kode = DB::table('ms_fasilitas_ruangans')->max('id');
    	$addNol = '';
    	$kode = str_replace("FS", "", $kode);
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

    	$kodeBaru = "FS".$addNol.$incrementKode;
    	return $kodeBaru;
    }
}
