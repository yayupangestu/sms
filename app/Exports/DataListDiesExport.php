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


class DataListDiesExport implements FromCollection,WithTitle,ShouldAutoSize,WithHeadings,WithEvents,WithMapping
{
    private $rowNumber = 1;

    public function title(): string{
		return 'Data List Dies';
	}

    public function collection()
    {
        set_time_limit(0);
        $qry = DB::table('tabel_list_dies as a')
                ->select('a.part_name','a.part_no','a.job_no','a.id as id','a.model_id','a.std_stroke','a.proses','a.line_id')
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
                $qry->model_id,
                $qry->line_id,
                $qry->std_stroke,
                $qry->proses,
                // $qry->qty_kanban,
            ],

        ];

    }

    public function headings(): array
    {
        return [
            ["Data List Dies"],
            [""],
            ["No",
            "Part Name",
            "Part No",
            "Job No", 
            "Model",
            "Line",
            "Std Stroke",
            "Proses",]
        ] ;								
    }

    public function registerEvents(): array
	{
		return [
			AfterSheet::class    => function(AfterSheet $event) {
				$cellRange = 'A1';
				$cellRange1 = 'A3:H3';
				$event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(18)->setBold(true);
				$event->sheet->getDelegate()->getStyle($cellRange1)->getFont()->setSize(12)->setBold(true);
                $event->sheet->mergeCells("A1:H1");
			},
		];
	}
}