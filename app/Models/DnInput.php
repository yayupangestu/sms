<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DnInput extends Model
{
    use HasFactory;
    
    protected $fillable = [
     'part_no',
     'actual',
     'supplier',
     'doc_po',
     'doc_dn',
     'spec,',
     'sts_scan',
     
    ];
}
