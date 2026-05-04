<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TabelTransitPcStore extends Model
{
    protected $fillable = [
        'part_no',
        'job_no',
        'qty_act',
        'count',
        'id_data',
        'sts',
        'createdby',
        'updatedby'
    ];
}
