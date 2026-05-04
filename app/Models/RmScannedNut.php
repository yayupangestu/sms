<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmScannedNut extends Model
{
    use HasFactory;
    protected $fillable = [
            'part_nut',
            'line',
            'createdby',
            'updatedby',
            'status',
    ];
}
