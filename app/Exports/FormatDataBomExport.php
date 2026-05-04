<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class FormatDataBomExport implements WithTitle, ShouldAutoSize, WithHeadings, WithEvents
{
    public function title(): string
    {
        return 'Template BOM';
    }

    public function headings(): array
    {
        return [
            [
                "Category (SUB ASSY / DIRECT)",
                "NO",
                "", // Sub-No column
                "JOB NO",
                "UNIQUE NO",
                "PART NAME",
                "PART NUMBER",
                "CUSTOMER",
                "MODEL",
                "VENDOR",
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $cellRange = 'A1:J1';

                // Yellow Header like in the image
                $event->sheet->getDelegate()->getStyle($cellRange)->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FEF9E7'); // Light yellow
    
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setBold(true);
                $event->sheet->getDelegate()->getStyle($cellRange)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                // Merge NO and the empty column next to it (now B1 and C1)
                $event->sheet->mergeCells("B1:C1");

                // Set borders for the header and some empty rows to look like the image
                $styleArray = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ];

                $event->sheet->getDelegate()->getStyle('A1:J50')->applyFromArray($styleArray);

                // Set column widths to match better
                $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(5); // Category
                $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(5);  // No Main
                $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(8);  // No Sub
                $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(20); // Job No
                $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(20); // Unique No
                $event->sheet->getDelegate()->getColumnDimension('F')->setWidth(40); // Part Name
                $event->sheet->getDelegate()->getColumnDimension('G')->setWidth(25); // Part Number
                $event->sheet->getDelegate()->getColumnDimension('H')->setWidth(25); // Customer
                $event->sheet->getDelegate()->getColumnDimension('I')->setWidth(20); // Model
                $event->sheet->getDelegate()->getColumnDimension('J')->setWidth(20); // Model
    
                // Alignment for NO columns
                $event->sheet->getDelegate()->getStyle('B2:C50')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            },
        ];
    }
}
