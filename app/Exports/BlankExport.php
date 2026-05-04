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


class BlankExport implements FromCollection,WithTitle,ShouldAutoSize,WithHeadings,WithEvents,WithMapping
{
    private $rowNumber = 1;

    public function title(): string{
		return 'Data Line Blank';
	}

    public function collection()
    {
        set_time_limit(0);
        $qry = DB::table('tabel_stok_blanks as a')
                ->select('a.id','a.type','a.part_name','a.job_no','a.part_no','a.model','a.customer','a.qty_min','a.qty_actual','a.qty_kanban','a.home_line','a.category','a.home_line','a.line_proses')
              
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
                $qry->type,
                $qry->job_no,
                $qry->part_no,
                $qry->model,
                $qry->customer,
                $qry->qty_min,
                $qry->qty_actual,
                $qry->qty_kanban,
                $qry->home_line,
            ],

        ];

    }

    public function headings(): array
    {
        return [
            ["Data Master & Stok Blank"],
            [""],
            ["No",
            "Type",
            "Job No", 
            "Part No",
            "Model",
            "Costumer",
            "qty_min",
            "qty_actual",
            "qty_kanban",
            "home_line"]
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