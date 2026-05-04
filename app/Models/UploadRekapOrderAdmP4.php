<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UploadRekapOrderAdmP4 extends Model
{
    use HasFactory;
    protected $fillable = [
        'doc_dn',
        'proses',
        'uniqNo'    ,
        'manifest'  ,
        'part_name'  ,
        'part_no'   ,
        'job_no'    ,
        'qty_kanban' ,
        'qty_order' ,
        'jml_kanban' , 
        'cycle',
        'proses',
        'type_pallet',
        'cycle_arrival',
         'route',
         'route2',
         'del_date'
    ];
}
