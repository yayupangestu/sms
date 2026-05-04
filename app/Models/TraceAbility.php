<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TraceAbility extends Model
{
    use HasFactory;
    protected $table = 'trace_abilities';
    protected $fillable = [
       'date_column',
       'line_id',
       'date_id',
       'material_id',
       'suplai_id',
       'no_pallet',
       'uniqNo',
       'name_material',
       'spek',
       'suplier',
       'qty_out',
       'scanrm_by',
       'material_id_stmp',
       'mo_in_stmp',
       'uniqNo_in_stmp',
       'name_material_in_stmp',
       'spek_in_stmp',
       'qty_out_in_stmp',
       'scanstmp_by',
       'part_no1',
       
    ];
            
    // protected $table = 'trace_abilities'; // Nama tabel
    // protected $fillable = ['UniqNo', 'status', 'created_at', 'updated_at']; // Kolom yang dapat diisi
}
