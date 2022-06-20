<?php

namespace App\Models\view\Qrgad;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VwKonsumableInventoris extends Model
{
    use HasFactory;
    protected $connection = "mysql9";
    protected $table = "vw_konsumable_inventoris";
    public $incrementing = false;
}
