<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanningLineC1 extends Model
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
        'updatedby'

      
    ];
}
