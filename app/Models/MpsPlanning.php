<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MpsPlanning extends Model
{
    use HasFactory;
    protected $fillable = [
        'part_name',
        'job_no',
        'part_no',
        'model_id',
        'qty_plan',
        'created_by',
        'updated_by',
        'status',
        'line_robot',
        'date_plan',
        'id_job',
    ];
}
