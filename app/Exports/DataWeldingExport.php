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


class DataWeldingExport implements FromCollection,WithTitle,ShouldAutoSize,WithHeadings,WithEvents,WithMapping
{
    private $rowNumber = 1;

    public function title(): string{
		return 'Data Welding';
	}

    public function collection()
    {
        set_time_limit(0);
        $qry = DB::table('data_weldings as a')
                ->select('a.part_name','a.part_no','a.job_no','a.id as id','a.model','qty_kanban')
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
                $qry->part_name,
                $qry->part_no,
                $qry->job_no,
                $qry->model,
                $qry->qty_kanban,
            ],

        ];

    }

    public function headings(): array
    {
        return [
            ["Data List Welding FG"],
            [""],
            ["No",
            "Part Name",
            "Part No",
            "Job No", 
            "Model",
            "Qty/Kanban",]
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