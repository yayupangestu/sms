<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmSupplierNut extends Model
{
    use HasFactory;
    protected $fillable = [
        'name_suplai',
        'pt',
        'alamat',
        'hp',
        'pic',
        'description',
        'createdby',
        'updatedby'

    ];
}
