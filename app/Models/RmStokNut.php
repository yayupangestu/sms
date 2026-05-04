<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmStokNut extends Model
{
    use HasFactory;
    protected $fillable = [
        'part_nut',
        'category',
        'minimal',
        'actual',
        'createdby',
        'updatedby',
    ];
}
