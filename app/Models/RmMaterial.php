<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmMaterial extends Model
{
    protected $fillable = [
        'name_material',
        'spek',
        'spek_t',
        'spek_p',
        'spek_l',
        'model',
        'category',
        'supplier',
        'sts',
        'createdby',
        'updatedby'
    ];
}
