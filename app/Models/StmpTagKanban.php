<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StmpTagKanban extends Model
{
    use HasFactory;
    protected $fillable = [
        'line_id',
        'product_id',
        'qty_plan',
        'qty_ng',
        'qty_gsph',
        'date_plan',
        'createdby',
        'updatedby',
        'doc_no',
        'sts_scan',
        'part_no_rm'
    ];
}
