<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StrSuplaier extends Model
{
    protected $fillable =[
        'name_suplai',
        'alamat',
        'pt',
        'pic',
        'hp',
        'descripton',
        'createdby',
        'updatedby',


    ];
}
