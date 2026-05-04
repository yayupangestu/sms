<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LkhDiesMtc extends Model
{
    use HasFactory;
    protected $fillable = [
        'doc_job',
        'date_plan',
       'part_name',
       'part_no',
       'job_no',
       'model_id',
       'line_id',
       'proses',
       'category',
       'problem',
       'tindakan',
       'dt_start',
       'dt_finish',
       'pic',
       'remarks',
       'updateby',
       'createdby',
    ];
}
