<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmInNut extends Model
{
    use HasFactory;
    protected $fillable = [
        'suplai_id',
        'category_id',
        'material_id',
        'qty_plan',
        'qty_in',
        'keterangan',
        'date_plan',
        'createdby',
        'updatedby',
    ];
}
