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

class MaterialInExport implements FromCollection, WithTitle, ShouldAutoSize, WithHeadings, WithEvents, WithMapping
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

    public function title(): string
    {
        return 'Data Material IN NPC';
    }

    public function collection()
    {
        // Query to fetch data between the selected start and end dates
        return DB::table('dn_inputs')
            ->whereBetween('created_at', [$this->startDate, $this->endDate])
            ->get();
    }

    public function map($qry): array
    {
        return [
            [
                $this->rowNumber++, // Increment row number for each item
                $qry->doc_po,
                $qry->doc_dn,
                $qry->part_no,
                $qry->model,
                $qry->spec,
                $qry->spec_t,
                $qry->spec_w,
                $qry->spec_l,
                $qry->supplier,
                $qry->update_time,
                $qry->actual,
                $qry->kg_sheet,
                $qry->createdby,
            ]
        ];
    }

    public function headings(): array
    {
        return [
            ["Data Material IN"],
            [""],
            [
                "No",
                "Doc Po",
                "Doc DN",
                "Part No",
                "Model",
                "Spec",
                "T",
                "W",
                "L",
                "Supplier",
                "Waktu Masuk",
                "Actual",
                "Kg",
                "Penerima"
                ]
        ];
    }

    public function registerEvents(): array
{
    return [
        AfterSheet::class => function(AfterSheet $event) {
            $cellRange = 'A1';
            $cellRange1 = 'A3:N3';

            // Set font for header and title
            $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(18)->setBold(true);
            $event->sheet->getDelegate()->getStyle($cellRange1)->getFont()->setSize(12)->setBold(true);

            // Merge title cells
            $event->sheet->mergeCells("A1:N1");

            // Set background colors for specific columns
            $event->sheet->getDelegate()->getStyle('L4:L' . ($event->sheet->getHighestRow()))
                ->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setRGB('90EE90'); // Light Green

            $event->sheet->getDelegate()->getStyle('M4:M' . ($event->sheet->getHighestRow()))
                ->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setRGB('FFFA4A'); // Yellow

            $event->sheet->getDelegate()->getStyle('K4:K' . ($event->sheet->getHighestRow()))
                ->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setRGB('D0FFF4'); // Light Cyan

            // Add borders around data (A3 to last row in column M)
            $event->sheet->getDelegate()->getStyle('A3:N' . $event->sheet->getHighestRow())
                ->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

            // Set the data range as a table
            $event->sheet->getDelegate()->setAutoFilter('A3:N' . $event->sheet->getHighestRow());

            // Optionally, set auto size for columns
            foreach (range('A', 'M') as $columnID) {
                $event->sheet->getColumnDimension($columnID)->setAutoSize(true);
            }

            // Align the headers to be centered
            $event->sheet->getDelegate()->getStyle('A3:N3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $event->sheet->getDelegate()->getStyle('A3:N3')->getFont()->setBold(true);
            $event->sheet->getDelegate()->getStyle('A3:N3')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('D3D3D3'); // Light Grey background for header
        },
    ];
}

}
