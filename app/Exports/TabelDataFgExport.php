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


class TabelDataFgExport implements FromCollection,WithTitle,ShouldAutoSize,WithHeadings,WithEvents,WithMapping
{
    private $rowNumber = 1;

    public function title(): string{
		return 'Data Welding';
	}

    public function collection()
    {
        set_time_limit(0);
        $qry = DB::table('data_fg_stampings as a')
                ->select('a.part_name','a.part_no','a.part_no2','a.job_no','a.model','a.spec','a.spec_t','a.spec_w','a.spec_l','a.spec_bq','a.spec_kg')
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
                 $qry->part_no2,
                $qry->job_no,
                $qry->model,
                $qry->spec,
                $qry->spec_t,
                $qry->spec_w,
                $qry->spec_l,
                $qry->spec_bq,
                $qry->spec_kg,
            ],

        ];

    }

    public function headings(): array
    {
        return [
            ["Data List Subcont"],
            [""],
            ["No",
            "Part Name",
            "Part No",
            "Job No",
            "Model",
            "Qty/Kanban",
            "Qty Line Store",
            "Stok PC-STORE",
            "Costumer",
            "Suppplier"]
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
