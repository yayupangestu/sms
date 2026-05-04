<?php

namespace App\Exports;

use App\Models\RmDnIncoming;
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

class PoExport implements FromCollection, WithTitle, ShouldAutoSize, WithHeadings, WithEvents, WithMapping
{
    protected $data;

    // Constructor untuk menerima data yang diteruskan
    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return $this->data; // Mengembalikan data yang difilter
    }

    public function title(): string
    {
        return 'Data Incoming';
    }

    public function map($qry): array
    {
        return [
            $qry->urutan,
            $qry->doc_dn,
            $qry->doc_po,
            $qry->part_no,
            $qry->supplier,
            $qry->kanban,
            $qry->model,
            $qry->spec,
            $qry->spec_t,
            $qry->spec_w,
            $qry->spec_l,
            $qry->spec_bq,
            $qry->spec_kg,
            $qry->order_sheet,
            $qry->order_kg,
            $qry->actual_sheet,
            $qry->actual_kg,
            $qry->balance_sheet,
            $qry->balance_weight,
            $qry->no_rak,
            $qry->created_at,
            $qry->status,
            $qry->delivery,
        ];
    }

    public function headings(): array
    {
        return [
            ["Data DN Incoming"],
            [""],
            [
                "No",
                "No DN",
                "NO PO",
                "Part No",
                "Supplier",
                "Kanban",
                "Model",
                "Spec",
                "T",
                "W",
                "L",
                "BQ",
                "Spec KG",
                "Order Sheet",
                "Order KG",
                "Actual Sheet",
                "Actual KG",
                "Balance Sheet",
                "Balance Weight",
                "No Rak",
                "Upload",
                "Status",
                "Tgl Diterima"
            ]
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $cellRange = 'A1';
                $cellRange1 = 'A3:W3';
    
                // Set font for header and title
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(18)->setBold(true);
                $event->sheet->getDelegate()->getStyle($cellRange1)->getFont()->setSize(12)->setBold(true);
    
                // Merge title cells
                $event->sheet->mergeCells("A1:W1");
    
                // Set background colors for specific columns
                $event->sheet->getDelegate()->getStyle('N4:N' . ($event->sheet->getHighestRow()))
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setRGB('90EE90'); // Light Green
    
                $event->sheet->getDelegate()->getStyle('O4:O' . ($event->sheet->getHighestRow()))
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setRGB('FFFA4A'); // Yellow
    
                $event->sheet->getDelegate()->getStyle('H4:H' . ($event->sheet->getHighestRow()))
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setRGB('D0FFF4'); // Light Cyan
    
                // Add borders around data (A3 to last row in column M)
                $event->sheet->getDelegate()->getStyle('A3:W' . $event->sheet->getHighestRow())
                    ->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    
                // Set the data range as a table
                $event->sheet->getDelegate()->setAutoFilter('A3:W' . $event->sheet->getHighestRow());
    
                // Optionally, set auto size for columns
                foreach (range('A', 'W') as $columnID) {
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

