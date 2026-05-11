<?php

namespace App\Exports;
use DB;
// use App\Models\StrOut;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithMapping;
// use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;

class ItemsInExport implements FromCollection, WithTitle, ShouldAutoSize, WithHeadings, WithEvents, WithMapping
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
        return 'Data Total Item-IN';
    }

    public function collection()
    {
        set_time_limit(0);
        $qry = DB::table('str_ins as a')
            ->select('a.qty_in', 'b.name as category_id', 'a.date_plan', 'c.name as item_id', 'a.id as id', 'd.name_suplai as suplai_id', 'e.name as satuan')
            ->leftJoin('str_categories as b', 'b.id', '=', 'a.category_id')
            ->leftJoin('master_list_strs as c', 'c.id', '=', 'a.item_id')
            ->leftJoin('str_suplaiers as d', 'd.id', '=', 'a.suplai_id')
            ->leftjoin('str_uoms as e', 'e.id', '=', 'a.satuan')
            ->whereBetween('a.date_plan', [$this->startDate, $this->endDate])
            ->get();

        return collect($qry);
    }


    public function map($qry): array
    {

        $items = [];
        foreach ($qry as $item) {
            array_push($items, $item);
        }

        return [
            [
                $this->rowNumber++,
                $qry->suplai_id,
                $qry->item_id,
                $qry->category_id,
                $qry->qty_in,
                $qry->satuan,
                $qry->date_plan
            ],

        ];

    }

    public function headings(): array
    {
        return [
            ["Data Total Item-Out"],
            [""],
            [
                "No",
                "Suplai",
                "Item Name",
                "Category",
                "Item In",
                "Satuan",
                "Date"
            ]
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $cellRange = 'A1';
                $cellRange1 = 'A3:I3';
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(18)->setBold(true);
                $event->sheet->getDelegate()->getStyle($cellRange1)->getFont()->setSize(12)->setBold(true);
                $event->sheet->mergeCells("A1:I1");
            },
        ];
    }
}




