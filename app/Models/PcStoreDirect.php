<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class PcStoreDirect extends Model
{
    protected $fillable = [
        'part_no2',
        'part_no',
        'job_no',
        'part_name',
        'qty_kanban',
        'qty_act',
        'model',
        'strength',
        'customer',
        'pallet',
        'monthly_volume',
        'daily_volume',
        'home_line',
        'vendor',
        'proses',
        'line',
    ];


    // protected static function booted()
    // {
    //     static::saving(function ($item) {
    //         // Ambil nilai actual dan daily_volume dari model
    //         $actual = (float) $item->actual;
    //         $daily_volume = (float) $item->daily_volume;

    //         // Hitung strenght dan format dengan koma (Indonesia)
    //         if ($actual > 0 && $daily_volume > 0) {
    //             $strenght = number_format($actual / $daily_volume, 1, ',', ''); // Format koma
    //         } else {
    //             $strenght = '0,0';
    //         }

    //         // Simpan strenght ke model
    //         $item->strenght = $strenght;

    //         // Konversi strenght ke float dengan mengganti koma menjadi titik
    //         $numericStrenght = floatval(str_replace(',', '.', $strenght));

    //         // Tentukan status berdasarkan nilai numericStrenght
    //         if ($numericStrenght <= 0.5) {
    //             $item->status = 'DANGER';
    //         } elseif ($numericStrenght > 0.5 && $numericStrenght <= 1) {
    //             $item->status = 'WARNING';
    //         } else {
    //             $item->status = 'SAFE';
    //         }
    //     });
    // }


}


