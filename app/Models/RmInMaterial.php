<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmInMaterial extends Model
{
    use HasFactory;
    protected $fillable = [
        'doc_no',
        'suplai_id',
        'category_id',
        'material_id',
        'qty_in',
        'keterangan',
        'date_plan',
        'createdby',
        'updatedby',
    ];
}
