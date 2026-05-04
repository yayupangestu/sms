<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LineStoreLabelSubcont extends Model
{
    use HasFactory;
    protected $fillable = [
        'no_dn',
        'part_no',
        'job_no',
        'qty_act',
        'supplier',
        'createdby',
        'updatedby',
        'alamat',
        'id_data',

    ];
}
