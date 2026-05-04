<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TabelC2 extends Model
{
    use HasFactory;
    protected $fillable = [
        'job_no',
        'part_no',
        'model_id',
        'spec_id',
        'type_id',
        'shop_id',
        'createdby',
        'updatedby'
    ];
}
