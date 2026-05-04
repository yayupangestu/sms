<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RbtTmmin extends Model
{
    use HasFactory;

    protected $fillable = [
        'part_name',
        'job_no',
        'part_no2',
        'part_no',
        'qty_proses',
        'createdby',
        'updatedby'
    ];
}
