<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class RmDnIncoming extends Model
{
    use HasFactory;

    // Set kolom yang boleh diisi
    protected $fillable = [
        'doc_dn',
        'doc_po',
        'supplier',
        'urutan',
        'part_no',
        'uniq_no',
        'kanban',
        'model',
        'spec',
        'spec_t',
        'spec_w',
        'spec_l',
        'spec_kg',
        'spec_bq',
        'kg_sheet',
        'order_sheet',
        'order_kg',
        'actual_sheet',
        'actual_kg',
        'actual_tgl',
        'balance_sheet',
        'balance_weight',
        'no_dn',
        'no_rak',
        'updatedby',
        'no_pallet',
        'delivery',
        'createdby',
    ];

    // Mutator untuk created_at
    public function setCreatedAt($value)
    {
        // Set only the year and month, ignoring the day, hour, minute, and second
        $this->attributes['created_at'] = Carbon::parse($value)->format('Y-m-01'); // Mengatur tanggal menjadi pertama bulan
    }
}
