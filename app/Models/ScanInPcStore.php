<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScanInPcStore extends Model
{
    protected $fillable = [
        'part_no2',  
        'part_no'    ,   
        'job_no'    ,  
        'model'     ,   
        'qty'       ,   
        'date'       ,  
        'uniqNo' ,
        'kodeMaterial'  ,
        'qty_ng'       ,
        'id_data'       , 
        'sts',
        'createdby',
        'updatedby'
    ];


  
}
