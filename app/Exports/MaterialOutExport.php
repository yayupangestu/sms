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

class MaterialOutExport implements FromCollection, WithTitle, ShouldAutoSize, WithHeadings, WithEvents, WithMapping
{
    private $startDate;
    private $endDate;
    private $rowNumber = 1; // Initialize row number property

    // Constructor to accept date filters
    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function title(): string{
		return 'Data Matarial Out NPC';
	}
    
    public function collection()
    {
        return DB::table('scan_out_rms')
            ->whereBetween('created_at', [$this->startDate,  $this->endDate])
            ->get();
    }

    public function map($qry): array
    {
        
      return [
            [
                $this->rowNumber++,
                $qry->uniqNo,
                $qry->part_no,
                $qry->spec,
                $qry->qty_out_sheet,
                $qry->qty_out_kg,
                $qry->supplier,
                $qry->createdby,
                $qry->created_at 
            ],

        ];

    }

    public function headings(): array
    {
        return [
            ["Data Material Out"],
            [""],
            ["No",
            "UniqNo",
            "Part No", 
            "Material",
            "Out-Sheet",
            "Out-kg",
            "Supplier",
            "PIC",
            "Waktu Keluar",
           ]
        ] ;								
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $cellRange = 'A1';
                $cellRange1 = 'A3:I3';
    
                // Set font for header and title
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(18)->setBold(true);
                $event->sheet->getDelegate()->getStyle($cellRange1)->getFont()->setSize(12)->setBold(true);
    
                // Merge title cells
                $event->sheet->mergeCells("A1:I1");
    
                // Set background colors for specific columns
                $event->sheet->getDelegate()->getStyle('E4:E' . ($event->sheet->getHighestRow()))
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setRGB('90EE90'); // Light Green
    
                $event->sheet->getDelegate()->getStyle('F4:F' . ($event->sheet->getHighestRow()))
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setRGB('FFFA4A'); // Yellow
    
                $event->sheet->getDelegate()->getStyle('G4:G' . ($event->sheet->getHighestRow()))
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setRGB('D0FFF4'); // Light Cyan
    
                // Add borders around data (A3 to last row in column M)
                $event->sheet->getDelegate()->getStyle('A3:I' . $event->sheet->getHighestRow())
                    ->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    
                // Set the data range as a table
                $event->sheet->getDelegate()->setAutoFilter('A3:I' . $event->sheet->getHighestRow());
    
                // Optionally, set auto size for columns
                foreach (range('A', 'I') as $columnID) {
                    $event->sheet->getColumnDimension($columnID)->setAutoSize(true);
                }
    
                // Align the headers to be centered
                $event->sheet->getDelegate()->getStyle('A3:I3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('A3:I3')->getFont()->setBold(true);
                $event->sheet->getDelegate()->getStyle('A3:I3')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('D3D3D3'); // Light Grey background for header
            },
        ];
    }
    
}