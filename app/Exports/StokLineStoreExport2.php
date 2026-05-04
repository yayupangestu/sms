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


class StokLineStoreExport2 implements FromCollection, WithTitle, ShouldAutoSize, WithHeadings, WithEvents, WithMapping
{
    private $rowNumber = 1;
    private $filter; // Variabel untuk filter

    public function __construct($filter)
    {
        $this->filter = $filter; // Set filter saat inisialisasi
    }

    public function title(): string
    {
        return 'Data Stok Part Line Store';
    }

    public function collection()
{
    // Ambil filter dari request
    $filter = request()->input('filter');

    // Query dasar dengan alias 'a'
    $query = DB::table('line_store_stoks as a');

    // Jika filter bukan 'all', maka tambahkan kondisi home_line = 'OUTHOUSE'
    if ($filter !== 'all') {
        $query->where('a.home_line', 'OUTHOUSE');
    }

    // Tambahkan kondisi berdasarkan filter
    if ($filter === 'safe') {
        $query->where(function ($q) {
            $q->whereColumn('a.qty_actual', '>', 'a.qty_min')
              ->orWhereColumn('a.qty_actual', '=', 'a.qty_min');
        });
    } elseif ($filter === 'critical') {
        $query->whereColumn('a.qty_actual', '<', 'a.qty_min');
    } elseif ($filter === 'ta') {
        // Menampilkan hanya data dengan qty_actual = 0 dan qty_min = 0
        $query->where('a.qty_actual', 0)
              ->where('a.qty_min', 0);
    }

    // Ambil data sesuai filter
    return $query->get();
}

    
    

    

    public function map($qry): array
    {
        return [
            $this->rowNumber++,
            $qry->part_name,
            $qry->part_no,
            $qry->job_no,
            $qry->model,
            $qry->customer,
            $qry->category,
            $qry->home_line,
            $qry->qty_kanban,
            $qry->qty_min,
            $qry->qty_actual,
            // $qry->supplier,
            // $qry->category,
         
        ];
    }

    public function headings(): array
    {
        // Judul dinamis berdasarkan filter
        $title = 'Data Stok Material NPC';
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
            ["No", "Part Name", "Part No", "Job No", "Model", "Category", "Material", "T", "W","L", "Minimal", "Actual Sheet", "Actual Kg", "No Rak"]
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $cellRange = 'A1';
                $cellRangeCategory = 'A2';
                $cellRange1 = 'A3:K3';
            
                // Set font for header and title
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(18)->setBold(true);
                $event->sheet->getDelegate()->getStyle($cellRangeCategory)->getFont()->setSize(18)->setBold(true);
                $event->sheet->getDelegate()->getStyle($cellRange1)->getFont()->setSize(12)->setBold(true);

                  // Tambahkan ini agar teks di A2 (cellRangeCategory) rata tengah horizontal
                  $event->sheet->getDelegate()->getStyle($cellRangeCategory)
                  ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            
                // Merge title cells
                $event->sheet->mergeCells("A1:K1");
             
            
                // Set background colors for specific columns
                $event->sheet->getDelegate()->getStyle('K4:K' . ($event->sheet->getHighestRow()))
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setRGB('90EE90'); // Light Green ACTUAL SHEET
            
                $event->sheet->getDelegate()->getStyle('J4:J' . ($event->sheet->getHighestRow()))
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setRGB('FFA500'); // Orange 
            
                $event->sheet->getDelegate()->getStyle('H4:H' . ($event->sheet->getHighestRow()))
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setRGB('D0FFF4'); // Light Cyan
            
                // Add borders around data (A3 to last row in column N)
                $event->sheet->getDelegate()->getStyle('A3:K' . $event->sheet->getHighestRow())
                    ->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            
                // Set the data range as a table
                $event->sheet->getDelegate()->setAutoFilter('A3:K' . $event->sheet->getHighestRow());
            
                // Optionally, set auto size for columns
                foreach (range('A', 'N') as $columnID) {
                    $event->sheet->getColumnDimension($columnID)->setAutoSize(true);
                }
            
                // Align the headers to be centered
                $event->sheet->getDelegate()->getStyle('A3:K3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('A3:K3')->getFont()->setBold(true);
                $event->sheet->getDelegate()->getStyle('A3:K3')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('D3D3D3'); // Light Grey background for header
    
                // Highlight empty cells, negative values, or values less than column K in column L
                $highestRow = $event->sheet->getHighestRow(); // Get the last row
    
                for ($row = 4; $row <= $highestRow; $row++) { // Start from row 4
                    $cellL = 'L' . $row;
                    $cellK = 'K' . $row;
                    
                    $valueL = $event->sheet->getDelegate()->getCell($cellL)->getValue();
                    $valueK = $event->sheet->getDelegate()->getCell($cellK)->getValue();
    
                    // If cell L is empty, set red background
                    if (empty($valueL)) {
                        $event->sheet->getDelegate()->getStyle($cellL)
                            ->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                            ->getStartColor()->setRGB('FF0000'); // Red
                    }
    
                    // If value in L is negative, set red background
                    if (!empty($valueL) && $valueL < 0) {
                        $event->sheet->getDelegate()->getStyle($cellL)
                            ->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                            ->getStartColor()->setRGB('FF0000'); // Red
                    }
    
                    // If value in L < value in K, set yellow background
                    if (!empty($valueL) && !empty($valueK) && $valueL < $valueK) {
                        $event->sheet->getDelegate()->getStyle($cellL)
                            ->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                            ->getStartColor()->setRGB('FFFF00'); // Yellow
                    }
                }
            },
        ];
    }
    
    
}

