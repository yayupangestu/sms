<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StrOut extends Model
{
    use HasFactory;
    protected $fillable = [
        'line_id',
        'item_id',
        'qty_return',
        'qty_request',
        'qty_out',
        'satuan',
        'keterangan',
        'date_plan',
        'createdby',
        'updateby',
    ];
}
