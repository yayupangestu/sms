<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataCostumer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'createdby',
        'updatedby'
    ];
}
