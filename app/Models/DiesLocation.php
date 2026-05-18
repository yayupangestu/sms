<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiesLocation extends Model
{
    use HasFactory;

    protected $fillable = [
        'location_name',
        'company_name',
        'address',
        'lat',
        'lng',
        'category',
        'is_active'
    ];
}