<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LineStoreScanIn extends Model
{
    use HasFactory;
    protected $fillable = [
        'uniqNo',
        'part_no',
        'job_no',
        'qty',
        'time',
        'createdby',
        'updatedby'
    ];
}
