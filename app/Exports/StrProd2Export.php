<?php

namespace App\Exports;

use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithMapping;

class StrProd2Export implements FromCollection, WithTitle, ShouldAutoSize, WithHeadings, WithEvents, WithMapping
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    private $rowNumber = 1;

    public function title(): string
    {
        return 'Data Total Item-Out';
    }

    public function collection()
    {
        set_time_limit(0);


        $query1 = DB::table('str_out15s as a')
            ->select('a.qty_out', 'b.name as satuan', 'a.date_plan', 'a.line_id', 'c.name as item_id', 'a.id as id', 'a.doc_no', 'a.qty_request', 'a.qty_return', 'a.price_item', 'a.keterangan')
            ->leftJoin('str_uoms as b', 'b.id', '=', 'a.satuan')
            ->leftJoin('master_list_strs as c', 'c.id', '=', 'a.item_id')
            ->whereBetween('a.date_plan', [$this->startDate, $this->endDate]);


        $query2 = DB::table('str_out16s as a')
            ->select('a.qty_out', 'b.name as satuan', 'a.date_plan', 'a.line_id', 'c.name as item_id', 'a.id as id', 'a.doc_no', 'a.qty_request', 'a.qty_return', 'a.price_item', 'a.keterangan')
            ->leftJoin('str_uoms as b', 'b.id', '=', 'a.satuan')
            ->leftJoin('master_list_strs as c', 'c.id', '=', 'a.item_id')
            ->whereBetween('a.date_plan', [$this->startDate, $this->endDate]);

        $query3 = DB::table('str_out17s as a')
            ->select('a.qty_out', 'b.name as satuan', 'a.date_plan', 'a.line_id', 'c.name as item_id', 'a.id as id', 'a.doc_no', 'a.qty_request', 'a.qty_return', 'a.price_item', 'a.keterangan')
            ->leftJoin('str_uoms as b', 'b.id', '=', 'a.satuan')
            ->leftJoin('master_list_strs as c', 'c.id', '=', 'a.item_id')
            ->whereBetween('a.date_plan', [$this->startDate, $this->endDate]);

        // Gabungkan hasil query menggunakan union
        $results = $query1->union($query2)->union($query3)->get();


        return collect($results);
    }

    public function map($qry): array
    {
        // Format harga item dengan 3 angka desimal
        $priceItem = number_format((float) $qry->price_item, 3, '.', '');

        return [
            $this->rowNumber++,
            $qry->doc_no,
            $qry->line_id,
            $qry->item_id,
            $qry->qty_return,
            $qry->qty_request,
            $qry->qty_out,
            $qry->satuan,
            $qry->date_plan,
            $priceItem,
            $qry->keterangan,
        ];
    }

    public function headings(): array
    {
        return [
            ["Data Total Item-Out Line Production 2  "],
            [""],
            ["No", "Doc No", "Line", "Item Name", "Qty Return", "Qty Request", "Qty Out", "Satuan", "Date", "Harga", "Description"],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $cellRange = 'A1';
                $cellRange1 = 'A2:K2';

                // Set font for header and title
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(18)->setBold(true);
                $event->sheet->getDelegate()->getStyle($cellRange1)->getFont()->setSize(12)->setBold(true);

                // Merge title cells
                $event->sheet->mergeCells("A1:K1");

                // Mengatur format angka untuk kolom harga dengan tiga angka desimal (Rupiah)
                $event->sheet->getDelegate()->getStyle('J2:J' . ($event->sheet->getHighestRow()))
                    ->getNumberFormat()
                    ->setFormatCode('[$Rp.]#,##0.000'); // Format mata uang Rupiah (IDR) dengan 3 angka desimal tanpa spasi
    
                // Set background colors for specific columns
                // Set warna hijau untuk kolom J (dari J5 hingga baris terakhir)
                $event->sheet->getDelegate()->getStyle('J5:J' . ($event->sheet->getHighestRow()))
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setRGB('90EE90'); // Warna hijau muda (LightGreen)
    
                // Add borders around data (A3 to last row in column M)
                $event->sheet->getDelegate()->getStyle('A3:J' . $event->sheet->getHighestRow())
                    ->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                // Set the data range as a table
                $event->sheet->getDelegate()->setAutoFilter('A3:J' . $event->sheet->getHighestRow());

                // Optionally, set auto size for columns
                foreach (range('A', 'J') as $columnID) {
                    $event->sheet->getColumnDimension($columnID)->setAutoSize(true);
                }

                // Align the headers to be centered
                $event->sheet->getDelegate()->getStyle('A3:K3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('A3:K3')->getFont()->setBold(true);
                $event->sheet->getDelegate()->getStyle('A3:K3')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('D3D3D3'); // Light Grey background for header
            },
        ];
    }
}