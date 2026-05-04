<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataFgStamping extends Model
{
    use HasFactory;

    protected $fillable = [
        'part_name',
        'job_no',
        'part_no2',
        'part_no',
        'category',
        'model',
        'spec',
        'spec_t',
        'spec_w',
        'spec_l',
        'spec_bq',
        'spec_kg',
        'name',
        'description',
        'createdby',
        'updatedby'
    ];
}


