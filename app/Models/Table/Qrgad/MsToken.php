<?php

namespace App\Models\Table\Qrgad;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MsToken extends Model
{
    use HasFactory;

    protected $connection = 'mysql9';
    protected $table = 'ms_token';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'token',
        'created_by',
        'updated_by',
    ];

    // public function ruangans(){
    //     return $this->hasMany(MsRuangan::class);
    // }

    public static function idOtomatis()
    {
        $kode = DB::table('ms_token')->max('id');
    	$addNol = '';
    	$kode = str_replace("TK", "", $kode);
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

    	$kodeBaru = "TK".$addNol.$incrementKode;
    	return $kodeBaru;
    }
}
