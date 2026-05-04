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


class FormatUploadForcast2 implements WithTitle,ShouldAutoSize,WithHeadings,WithEvents
{
    private $rowNumber = 1;

    public function title(): string{
		return 'FORMAT UPLOAD FORCAST MONTHLY';
	}

    public function headings(): array
    {
        return [
            ["FORMAT UPLOAD FORCAST MONTHLY"],
            [""],
            [
            "UNIQUE NO",
            "MODEL",
            "QTY/KANBAN",
            "COSTUMER",
            "TAHUN",
            "JAN",
            "FEB",
            "MAR",
            "APR",
            "MEI",
            "JUN",
            "JUL",
            "AGUS",
            "SEP",
            "OKT",
            "NOV",
            "DES",
            ]
        ] ;
    }


    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                // Judul
                $event->sheet->getDelegate()->mergeCells("A1:Q1");
                $event->sheet->getDelegate()->getStyle('A1')->getFont()
                    ->setSize(18)
                    ->setBold(true);
                $event->sheet->getDelegate()->getStyle('A1')
                    ->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                // Header tabel (baris ke-3)
                $headerRange = 'A3:Q3';
                $event->sheet->getDelegate()->getStyle($headerRange)->getFont()
                    ->setSize(12)
                    ->setBold(true)
                    ->getColor()->setARGB('FFFFFFFF'); // putih
                $event->sheet->getDelegate()->getStyle($headerRange)
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FF4F81BD'); // biru
                $event->sheet->getDelegate()->getStyle($headerRange)
                    ->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                // Border untuk semua sel yang berisi data
                $highestRow = $event->sheet->getDelegate()->getHighestRow();
                $highestColumn = $event->sheet->getDelegate()->getHighestColumn();
                $dataRange = 'A3:' . $highestColumn . $highestRow;
                $event->sheet->getDelegate()->getStyle($dataRange)
                    ->getBorders()->getAllBorders()
                    ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN)
                    ->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('FF000000'));

                // Auto wrap text
                $event->sheet->getDelegate()->getStyle($dataRange)
                    ->getAlignment()->setWrapText(true);
            },
        ];
    }

}
