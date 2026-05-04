<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TraceProses2 extends Model
{
    use HasFactory;
    protected $fillable = [
        'date_plan',
        'uniqNo',
        'plan_mesin',
        'plan_jobNo',
        'plan_partNo',
        'plan_modal',
        'plan_qty',
        'plan_user',
    ];
}
