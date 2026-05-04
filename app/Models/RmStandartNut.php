<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmStandartNut extends Model
{
    use HasFactory;
    protected $fillable = [
        'part_nut',
        'name_nut',
        'supplier_id',
        'packing_box',
        'packing_kantong',
        'sts'
    ];
}
