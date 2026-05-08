<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StrStokRtk extends Model
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
