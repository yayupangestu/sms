<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScanInLineStore extends Model
{
    use HasFactory;
    protected $fillable = [
        'uniqNo',
        'job_no',
        'part_no',
        'part_no2', // Make sure this is included
        'model',
        'qty',
        'qty_ng',
        'date',
        'kodeMaterial',
        'part_no_rm',
        'createdby',
        'updatedby',
    ];
}
