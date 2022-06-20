<?php

namespace App\Models\Table\Qrgad;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MsGrupAset extends Model
{
    use HasFactory;

    protected $connection = 'mysql9';
    protected $table = 'ms_grup_asets';
    public $incrementing = false;
}
