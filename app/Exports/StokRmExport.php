<?php

namespace App\Exports;
use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithMapping;


class StokRmExport implements FromCollection, WithTitle, ShouldAutoSize, WithHeadings, WithEvents, WithMapping
{
    private $rowNumber = 1;
    private $filter; // Variabel untuk filter

    public function __construct($filter)
    {
        $this->filter = $filter; // Set filter saat inisialisasi
    }

    public function title(): string
    {
        return 'Data Stok Material MPC';
    }

    public function collection()
    {
        // Query dasar
        $query = DB::table('rm_stoks as a');

        // Tambahkan kondisi berdasarkan filter
        if ($this->filter === 'safe') {
            $query->where(function ($query) {
                $query->whereColumn('a.actual_sheet', '>=', 'a.minimal');
            })->where('a.keterangan', '!=', 2);

        } elseif ($this->filter === 'critical') {
            $query->whereColumn('a.actual_sheet', '<', DB::raw('a.minimal'))
                  ->where('a.actual_sheet', '>', 0)
                  ->where('a.keterangan', '!=', 2);

        } elseif ($this->filter === 'ta') {
            $query->where('a.actual_sheet', '=', 0)
                  ->where('a.keterangan', '!=', 2);

        } elseif ($this->filter === 'runout'){
            $query->where('a.keterangan', 2);
        }

        // Ambil data
        $data = $query->get();

        // Ubah nilai kolom 'keterangan' sebelum dikembalikan
        $mapped = $data->map(function ($item) {
            $item->keterangan = $item->keterangan == 2 ? 'Runout' : 'Aktif';
            return $item;
        });

        return $mapped;
    }




    public function map($qry): array
    {
        return [
            $this->rowNumber++,
            $qry->part_name,
            $qry->part_no,
            $qry->job_no,
            $qry->model_id,
            $qry->category_id,
            $qry->spek,
            $qry->spek_t,
            $qry->spek_w,
            $qry->spek_l,
            $qry->minimal,
            $qry->actual_sheet,
            $qry->actual_kg,
            $qry->no_rak,
            $qry->supplier,
            $qry->keterangan,
        ];
    }

    public function headings(): array
    {
        // Judul dinamis berdasarkan filter
        $title = 'Data Stok Material MPC';
        $subtitle = '';

        switch ($this->filter) {
            case 'safe':
                $subtitle = 'Material Safe';
                break;
            case 'critical':
                $subtitle = 'Material Critical';
                break;
            case 'ta':
                $subtitle = 'Material Tidak Ada (TA)';
                break;
            case 'runout':
                $subtitle = 'Material Run Out';
                break;
            default:
                $subtitle = 'Material (All)';
                break;
        }

        return [
            ["{$title}"],
            ["{$subtitle}"], // Baris kedua sekarang pakai subtitle dinamis
            ["No", "Part Name", "Part No", "Job No", "Model", "Category", "Material", "T", "W","L", "Minimal", "Actual Sheet", "Actual Kg", "No Rak","Supplier","Status"]
        ];
    }


    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $cellRange = 'A1';
                $cellRangeCategory = 'A2';
                $cellRange1 = 'A3:N3';

                $event->sheet->mergeCells('A1:O1');
                $event->sheet->mergeCells('A2:O2');

                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(18)->setBold(true);
                $event->sheet->getDelegate()->getStyle($cellRangeCategory)->getFont()->setSize(18)->setBold(true);
                $event->sheet->getDelegate()->getStyle($cellRange1)->getFont()->setSize(12)->setBold(true);
                $event->sheet->getDelegate()->getStyle($cellRangeCategory)
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $event->sheet->getDelegate()->getStyle('L4:L' . ($event->sheet->getHighestRow()))
                    ->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setRGB('90EE90'); // Light Green

                $event->sheet->getDelegate()->getStyle('K4:K' . ($event->sheet->getHighestRow()))
                    ->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setRGB('FFA500'); // Orange

                $event->sheet->getDelegate()->getStyle('M4:M' . ($event->sheet->getHighestRow()))
                    ->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setRGB('D0FFF4'); // Light Cyan

                $event->sheet->getDelegate()->getStyle('A3:O' . $event->sheet->getHighestRow())
                    ->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                $event->sheet->getDelegate()->setAutoFilter('A3:O'. $event->sheet->getHighestRow());

                foreach (range('A', 'N') as $columnID) {
                    $event->sheet->getColumnDimension($columnID)->setAutoSize(true);
                }

                $event->sheet->getDelegate()->getStyle('A3:O3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('A3:O3')->getFont()->setBold(true);
                $event->sheet->getDelegate()->getStyle('A3:O3')->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setRGB('D3D3D3');

                $highestRow = $event->sheet->getHighestRow();

                for ($row = 4; $row <= $highestRow; $row++) {
                    $cellL = 'L' . $row;
                    $cellK = 'K' . $row;
                    $cellN = 'N' . $row;

                    $valueL = $event->sheet->getDelegate()->getCell($cellL)->getValue();
                    $valueK = $event->sheet->getDelegate()->getCell($cellK)->getValue();
                    $valueN = $event->sheet->getDelegate()->getCell($cellN)->getValue();

                    if (empty($valueL)) {
                        $event->sheet->getDelegate()->getStyle($cellL)
                            ->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                            ->getStartColor()->setRGB('FF0000'); // Red
                    }

                    if (!empty($valueL) && $valueL < 0) {
                        $event->sheet->getDelegate()->getStyle($cellL)
                            ->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                            ->getStartColor()->setRGB('FF0000'); // Red
                    }

                    if (!empty($valueL) && !empty($valueK) && $valueL < $valueK) {
                        $event->sheet->getDelegate()->getStyle($cellL)
                            ->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                            ->getStartColor()->setRGB('FFFF00'); // Yellow
                    }

                    // Highlight kolom N berdasarkan nilai
                    if ($valueN === 2 || strtolower($valueN) === 'runout') {
                        $event->sheet->getDelegate()->getStyle($cellN)
                            ->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                            ->getStartColor()->setRGB('FF0000'); // Merah untuk Runout
                    } elseif ($valueN === 1 || strtolower($valueN) === 'aktif') {
                        $event->sheet->getDelegate()->getStyle($cellN)
                            ->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                            ->getStartColor()->setRGB('00FF00'); // Hijau untuk Aktif
                    }
                }
            },
        ];
    }


}

