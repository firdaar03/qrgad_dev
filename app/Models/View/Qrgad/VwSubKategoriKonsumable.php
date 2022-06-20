<?php

namespace App\Models\View\Qrgad;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VwSubKategoriKonsumable extends Model
{
    use HasFactory;
    public $incrementing = false;

    protected $connection = "mysql9";
    protected $table ='vw_sub_kategori_konsumables';
}
