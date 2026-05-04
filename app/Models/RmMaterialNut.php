<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmMaterialNut extends Model
{
    use HasFactory;
    protected $fillable = [
        'part_no',
        'job_no',
        'model_id',
        'type_id',
        'spec_nut',
        'sipplier',
        'sts'
    ];
}
