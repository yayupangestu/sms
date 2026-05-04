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


class GasExport implements FromCollection,WithTitle,ShouldAutoSize,WithHeadings,WithEvents,WithMapping
{
    private $rowNumber = 1;

    public function title(): string{
		return 'Data Stok GAS';
	}

    public function collection()
    {
        set_time_limit(0);
        $qry = DB::table('str_stok_gases as a')
                ->select('a.category','a.actual','a.minimal','c.name as item_id','a.id as id','b.name as satuan')
                ->join('str_uoms as b', 'b.id', '=', 'a.satuan', 'left')
                ->join('str_barangs as c', 'c.id', '=', 'a.item_id','left')
                ->get(); 
                return collect($qry);
    }

    public function map($qry): array
    {
        
        $items = [];
        foreach($qry as $item){
            array_push($items, $item);
        }

        return [
            [
                $this->rowNumber++,
                $qry->item_id,
                $qry->category,
                $qry->minimal,
                $qry->actual,
                $qry->satuan
            ],

        ];

    }

    public function headings(): array
    {
        return [
            ["Data Stok List Gas"],
            [""],
            ["No",
            "Item Name",
            "Category", 
            "Minimal",
            "Actual",
            "Satuan"]
        ] ;								
    }

    public function registerEvents(): array
	{
		return [
			AfterSheet::class    => function(AfterSheet $event) {
				$cellRange = 'A1';
				$cellRange1 = 'A3:I3';
				$event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(18)->setBold(true);
				$event->sheet->getDelegate()->getStyle($cellRange1)->getFont()->setSize(12)->setBold(true);
                $event->sheet->mergeCells("A1:I1");
			},
		];
	}
}