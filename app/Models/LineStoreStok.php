<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LineStoreStok extends Model
{
    use HasFactory;
    protected $fillable = [
         'category',
            'job_no',
            'part_name' ,
            'part_no',
            'part_no2',
            'customer',
            'model',
            'qty_min',
            'qty_actual',
            'qty_kanban',
            'home_line',
            'line_proses',
            'createdby',
    ];
}
