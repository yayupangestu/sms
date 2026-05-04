<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LkhB3 extends Model
{
    use HasFactory;
    protected $fillable = [
        'line_id',
        'product_id',
        'qty_plan',
        'material_id',
        'date_plan',
        'createdby',
        'updatedby'
    ];
}
