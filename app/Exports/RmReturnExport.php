<?php

namespace App\Exports;
use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;
// use Illuminate\Support\Facades\DB;

class RmReturnExport implements FromCollection, WithTitle, ShouldAutoSize, WithHeadings, WithEvents, WithMapping
{
    private $rowNumber = 1;

    public function title(): string
    {
        return 'Material Return data';
    }

    public function collection()
    {
        set_time_limit(0);
        return DB::table('rm_return_materials as a')
            ->select(
                'a.uniqNo',
                'a.spec',
                'a.part_no',
                'a.supplier',
                'a.qty_awal',
                'a.scan_by',
                'a.qty_return',
                'a.createdby',
                'a.time',
                'a.line_id',
                'a.sts'
            )
            ->get();
    }

    public function map($row): array
    {
        // Mapping status ke teks
        $statusText = 'Material Ready'; // default null
        if ($row->sts == 1) {
            $statusText = 'Material Ready (Belum diterima)';
        } elseif ($row->sts == 2) {
            $statusText = 'Material Diterima';
        }

        return [
            $this->rowNumber++,
            $row->uniqNo,
            $row->part_no,
            $row->spec,
            $row->supplier,
            $row->qty_awal,
            $row->qty_return,
            $row->scan_by,
            $row->line_id,
            $row->time,
            $statusText,
        ];
    }

    public function headings(): array
    {
        return [
            ["Data List Material Sisa MPC"],
            [""],
            [
                "No",
                "Unique No",
                "Part No",
                "Spec",
                "Supplier",
                "Qty Awal",
                "Qty Sisa",
                'Dikirim',
                'Line',
                'Tanggal',
                'Status'
            ]
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Judul besar
                $sheet->getStyle('A1')->getFont()->setSize(18)->setBold(true);
                $sheet->mergeCells('A1:K1');

                // Header baris ke-3
                $sheet->getStyle('A3:K3')->getFont()->setBold(true)->setSize(12);

                // Auto filter untuk header
                $sheet->setAutoFilter('A3:K3');

                // Dapatkan batas baris data
                $highestRow = $sheet->getHighestRow();

                // Tambahkan border ke seluruh area tabel
                $sheet->getStyle('A3:K' . $highestRow)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'],
                        ],
                    ],
                ]);

                // Warna background untuk kolom Status (Kolom K)
                for ($row = 4; $row <= $highestRow; $row++) {
                    $statusCell = 'K' . $row;
                    $statusText = $sheet->getCell($statusCell)->getValue();

                    $fillColor = null;
                    if ($statusText === 'Material Ready') {
                        $fillColor = 'C6EFCE'; // Hijau muda
                    } elseif ($statusText === 'Material Ready (Belum diterima)') {
                        $fillColor = 'D9E1F2'; // Biru muda
                    } elseif ($statusText === 'Material Diterima') {
                        $fillColor = 'FFF2CC'; // Kuning muda
                    }

                    if ($fillColor) {
                        $sheet->getStyle($statusCell)->applyFromArray([
                            'fill' => [
                                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                                'startColor' => ['rgb' => $fillColor],
                            ]
                        ]);
                    }
                }
            },
        ];
    }
}
