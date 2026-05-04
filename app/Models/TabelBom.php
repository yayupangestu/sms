<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TabelBom extends Model
{
    use HasFactory;
    protected $fillable = [
        'part_name',
        'part_name2',
        'model_id',
        'uniqNo',
        'job_no',
        'model',
        'part_no',
        'part_no2',
        'category_id',
        'vendor',
        'customer',
        'createdby',
        'updateby',
        'created_at',
        'updated_at'
    ];
}
