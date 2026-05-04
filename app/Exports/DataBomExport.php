<?php

namespace App\Exports;

use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class DataBomExport implements FromCollection, WithTitle, ShouldAutoSize, WithHeadings, WithEvents
{
    public function title(): string
    {
        return 'Data BOM';
    }

    public function collection()
    {
        set_time_limit(0);
        
        // Get all data grouped by mother part to build hierarchy
        $data = DB::table('tabel_boms')
            ->select('category_id', 'job_no', 'part_no', 'part_name', 'model_id', 'part_no2', 'part_name2', 'vendor', 'customer')
            ->orderBy('part_no')
            ->orderBy('job_no')
            ->get();

        $exportData = collect();
        $grouped = $data->groupBy(function($item) {
            return $item->part_no . '|' . $item->job_no . '|' . $item->customer;
        });

        $mainNo = 1;
        foreach ($grouped as $group) {
            $first = $group->first();
            $category = ($first->category_id == 1) ? 'SUB ASSY' : (($first->category_id == 2) ? 'DIRECT' : '-');
            
            // 1. Mother Row
            $exportData->push([
                'category' => $category,
                'no' => $mainNo,
                'no_item' => '',
                'job_no' => $first->job_no,
                'unique_no' => $first->part_no,
                'part_name' => $first->part_name,
                'part_number' => $first->part_no, // Mother part number
                'customer' => $first->customer, 
                'model' => $first->model_id,
                'vendor' => $first->vendor, // Vendor ONLY on mother row
            ]);

            // 2. Child Rows
            $subNo = 1;
            foreach ($group as $item) {
                $exportData->push([
                    'category' => '',
                    'no' => '',
                    'no_item' => $mainNo . ',' . $subNo,
                    'job_no' => $item->part_no2,
                    'unique_no' => $item->part_no2,
                    'part_name' => $item->part_name2,
                    'part_number' => $item->part_no2,
                    'customer' => $item->customer,
                    'model' => $item->model_id,
                    'vendor' => '', // Empty for child rows
                ]);
                $subNo++;
            }
            $mainNo++;
        }

        return $exportData;
    }

    public function headings(): array
    {
        return [
            [
                "Category",
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
                
                // Yellow Header
                $event->sheet->getDelegate()->getStyle($cellRange)->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FEF9E7');
                
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setBold(true);
                $event->sheet->getDelegate()->getStyle($cellRange)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                // Merge NO
                $event->sheet->mergeCells("B1:C1");

                // Set borders
                $rowCount = $event->sheet->getHighestRow();
                $styleArray = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ];

                $event->sheet->getDelegate()->getStyle('A1:J' . $rowCount)->applyFromArray($styleArray);
                
                // Set column widths
                $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(15);
                $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(5);
                $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(8);
                $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('F')->setWidth(40);
                $event->sheet->getDelegate()->getColumnDimension('G')->setWidth(25);
                $event->sheet->getDelegate()->getColumnDimension('H')->setWidth(25);
                $event->sheet->getDelegate()->getColumnDimension('I')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('J')->setWidth(20);
                
                // Alignment
                $event->sheet->getDelegate()->getStyle('B2:C' . $rowCount)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            },
        ];
    }
}
