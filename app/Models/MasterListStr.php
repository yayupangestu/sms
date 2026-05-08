<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterListStr extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'category',
        'description',
        'item_code',
        'price',
        'cratedby',
        'updatedby',

    ];
}
