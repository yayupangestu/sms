<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataWelding extends Model
{
    use HasFactory;
    
    protected $fillable = [
      'part_name',
      'part_no',
      'part_no2',
      'job_no',
      'model',
      'qty_kanban',
      'customer',
      'description',
      'createdby',
      'updateby',
      'part_no',
    ];
}
