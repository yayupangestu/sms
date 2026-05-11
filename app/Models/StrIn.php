<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StrIn extends Model
{
    use HasFactory;
    protected $fillable =[
        'category_id',
        'item_id',
        'suplai_id',
        'qty_in',
        'satuan',
        'keterangan',
        'date_plan',
        'createdby',
        'updateby',
    ];
}
