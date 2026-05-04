<?php

// app/Models/RmHistory.php
// app/Models/RmHistory.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmHistory extends Model
{
    use HasFactory;

    protected $table = 'rm_histories';

    protected $fillable = [
        'scanned_text',
        // tambahkan field lain yang perlu disimpan
    ];
}



