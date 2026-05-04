<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TabelStokBlank extends Model
{
    use HasFactory;
    protected $fillable = [
        'part_name',        
        'part_no',    
        'part_no2',           
        'job_no',           
        'model_id',           
        'spek',             
        'spek_t',           
        'spek_w',            
        'spek_l',        
        'spek_kg',            
        'spek_bq',       
        'supplier',         
        'qty_min',          
        'qty_actual',      
        'qty_kanban',        
        'no_rak',    
        'status',
        'bq_id',
        'qty_act',
        'tanggal',
        'home_line',
        'category',
        'sts',
        'line_proses',
        'doc_po',
    ];
}
