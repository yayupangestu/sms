<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TabelB3 extends Model
{
    use HasFactory;
    protected $fillable = [
        'job_no',
        'part_no',
        'model_id',
        'spec_id',
        'type_id',
        'line_id',
        'createdby',
        'updatedby'
    ];
    
}
