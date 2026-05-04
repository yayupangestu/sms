<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UploadForcast extends Model
{
    use HasFactory;
    protected $fillable = [
        'job_no',
        'uniqNo',
        'part_name',
        'part_no',
        'part_no2',
        'model',
        'qty_kanban',
        'customer',
        'tahun',
        'jan',
        'jan_month',
        'feb_month',
        'mar_month',
        'apr_month',
        'may_month',
        'jun_month',
        'aug_month',
        'sep_month',
        'oct_month',
        'nov_month',
        'dec_month',
        'feb',
        'mar',
        'apr',
        'may',
        'jun',
        'jul',
        'aug',
        'sep',
        'oct',
        'nov',
        'dec',
    ];



}
