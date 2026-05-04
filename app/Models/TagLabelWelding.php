<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TagLabelWelding extends Model
{
    use HasFactory;
    protected $fillable = [
        'part_name',        
        'part_no',    
        'part_no2',           
        'job_no',           
        'model_id',         
        'category_id',      
        'spek',             
        'spek_t',           
        'spek_w',            
        'spek_l',        
        'spek_kg',            
        'spek_bq',       
        'supplier',         
        'minimal',          
        'actual_sheet',      
        'actual_kg',        
        'no_rak',    
        'status',
        'bq_id',
        'qty_act',
        'tanggal',
        'home_line',
        'category',
        'sts',
        'count',
        'doc_po',
    ];
}
