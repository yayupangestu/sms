<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TabelListDies extends Model
{
    use HasFactory;
    protected $fillable = [
        'part_name',
        'std_stroke',
        'job_no',
        'part_no',
        'model_id',
        'spec_id',
        'type_id',
        'line_id',
        'proses',
        'customer',
        'createdby',
        'updatedby'
    ];
}
