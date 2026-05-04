<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TagLabelBlank extends Model
{
    use HasFactory;
    protected $fillable = [
        'doc_no',
        'product_id',
        'part_name',
        'job_no',
        'part_no',
        'part_no2',
        'qty_act',
        'qty_ng',
        'qty_sisa',
        'createdby',
        'updatedby',
        'kode_material',
        'sts_scan'
    ];
}
