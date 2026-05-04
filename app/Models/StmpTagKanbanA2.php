<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StmpTagKanbanA2 extends Model
{
    use HasFactory;
    protected $fillable = [
        'doc_no',
        'line_id',
        'item_id',
        'job_no',
        'part_name',
        'part_no',
        'model',
        'name_material',
        'qty_ok',
        'qty_ng',
        'date_plan',
        'createdby',
        'updateby',
        'created_at',
        'updated_at',
        'time_start',
        'time_end',
        'sts',
        'no',
        'shift',
        'uniqNo',
        'tujuan',
    ];
}
