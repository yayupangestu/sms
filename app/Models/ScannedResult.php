<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScannedResult extends Model
{
    use HasFactory;
    protected $fillable = [
            'result_text',
            'status',
            'status2',
            'created_at',
            'created_by_name',
            'qty_out',
            'mataerial_id',
            'id_material',
            
    ];

}
