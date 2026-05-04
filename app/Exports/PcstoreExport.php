<?php

namespace App\Exports;

use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

class PcstoreExport implements FromCollection, WithTitle, ShouldAutoSize, WithHeadings, WithEvents, WithMapping
{
    private $rowNumber = 1;

    public function title(): string
    {
        return 'Data Part Name';
    }

    public function collection()
    {
        set_time_limit(0);
        return DB::table('pc_store_directs as a')
            ->select('a.part_name', 'a.part_no', 'a.job_no', 'a.model', 'a.customer', 'a.qty_kanban', 'a.strength', 'a.qty_act','vendor','home_line','proses_line','line')
            ->get();
    }

    public function map($row): array
    {
        return [
            $this->rowNumber++,
            $row->part_name,
            $row->part_no,
            $row->job_no,
            $row->model,
            $row->customer,
            $row->qty_kanban,
            $row->strength,
            $row->qty_act,
            $row->home_line,
            $row->vendor,
            $row->proses_line,
             $row->line,
        ];
    }

    public function headings(): array
    {
        return [
            ['Data PC-STORE'],
            [''],
            ['No', 'Part Name', 'Part No', 'Job No', 'Model', 'Customer', 'Qty Kanban', 'Strength', 'Qty Actual','Home Line','Vendor','Proses','line']
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // === Header style ===
                $sheet->getStyle('A1')->getFont()->setSize(18)->setBold(true);
                $sheet->mergeCells('A1:M1');
                $sheet->getStyle('A3:M3')->getFont()->setBold(true);
                $sheet->getRowDimension(3)->setRowHeight(20);

                // === Tambahkan filter di header (baris ke-3) ===
                $sheet->setAutoFilter('A3:M3');

                // === Hitung total baris data ===
                $highestRow = $sheet->getHighestRow();

                // === Tambahkan border (grid) di seluruh area data ===
                $sheet->getStyle('A3:M' . $highestRow)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => 'FF000000'],
                        ],
                    ],
                ]);

                // === Loop data untuk pewarnaan Strength & Qty Actual ===
                for ($row = 4; $row <= $highestRow; $row++) {
                    $strength = $sheet->getCell('H' . $row)->getValue();
                    $color = null;

                    if ($strength > 1.0) {
                        $color = '90EE90'; // Hijau lembut
                    } elseif ($strength < 1.0 && $strength >= 0.5) {
                        $color = 'FFD580'; // Oranye lembut
                    } elseif ($strength < 0.5 && $strength >= 0.1) {
                        $color = 'FFFACD'; // Kuning lembut
                    } elseif ($strength == 0.0) {
                        $color = 'FF7F7F'; // Merah lembut
                    }

                    if ($color) {
                        $sheet->getStyle('H' . $row . ':I' . $row)->getFill()
                            ->setFillType(Fill::FILL_SOLID)
                            ->getStartColor()->setARGB($color);
                    }
                }
            },
        ];
    }
}
