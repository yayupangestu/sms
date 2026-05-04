<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LineStoreIncomingPart extends Model
{
    use HasFactory;
    protected $fillable = [
        'part_name',
        'job_no',
        'part_no',
        'model',
        'order_part',
        'balance_order',
        'no_dn',
        'no_dn2',
        'no_po',
        'tgl_delivery',
        'supplier',
        'actual_order'
        
    ];
}
