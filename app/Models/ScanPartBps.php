<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScanPartBps extends Model
{
    use HasFactory;
    protected $fillable = ['uniqNo', 'job_no', 'part_no2', 'model', 'qty','qty_ng', 'additional_qty','date_scan'];
}
