<?php

namespace App\Models\Table\Qrgad;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DtRuangan extends Model
{
    use HasFactory;

    protected $connection = 'mysql9';
    protected $table = 'dt_ruangans';
    
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'fasilitas',
        'ruangan',
        'jumlah',
    ];

}
