<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LineStoreUpload extends Model
{
    use HasFactory;
    protected $table = 'line_store_uploads'; // Pastikan nama tabel benar
    protected $fillable = [
        'part_name',
        'job_no',
        'part_no',
        'model',
        'order_part',
        'balance_order',
        'no_dn',
        'no_po',
        'no_dn2',
        'tgl_delivery',
        'supplier',
        'id_data',
        
    ];
}
