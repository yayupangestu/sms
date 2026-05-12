<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Str2StokRtk extends Model
{
    use HasFactory;
    protected $fillable = [
        'item_id',
        'category',
        'minimal',
        'actual',
        'satuan',
        'createdby',
        'updatedby',
    ];
}
