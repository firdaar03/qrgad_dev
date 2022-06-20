<?php

namespace App\Models\View\Qrgad;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VwItemOut extends Model
{
    use HasFactory;
    protected $connection = "mysql9";
    protected $table ='vw_item_outs';
    public $incrementing = false;
    public $timestamps = false;
}
