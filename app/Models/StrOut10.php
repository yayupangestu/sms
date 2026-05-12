<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StrOut10 extends Model
{
    use HasFactory;
    protected $fillable = [
        'doc_no',
        'line_id',
        'item_id',
        'qty_standing',
        'qty_return',
        'qty_request',
        'qty_out',
        'satuan',
        'actual',
        'keterangan2',
        'keterangan',
        'date_plan',
        'sts',
        'createdby',
        'updateby',
        'status',
        'w_dibuat',
        'w_diberi',
        'update_checklist',
        'status_checklist',
        'total_outstanding',
        'outstanding',
    ];
}
