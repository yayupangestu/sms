<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiesTransaction extends Model
{
    use HasFactory;

    protected $table = 'dies_transactions';

    protected $fillable = [
        'dies_qr',
        'dies_code',
        'dies_name',
        'transaction_type',

        'destination_address',
        'destination_lat',
        'destination_lng',

        'scan_address',
        'scan_lat',
        'scan_lng',

        'pic',
        'line',
        'note',

        'status',
        'user_id',
    ];
}