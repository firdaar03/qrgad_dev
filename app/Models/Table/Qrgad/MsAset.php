<?php

namespace App\Models\Table\Qrgad;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MsAset extends Model
{
    use HasFactory;
    protected $connection = 'mysql9';
    protected $table = 'ms_asets';
    public $incrementing = false;
}
