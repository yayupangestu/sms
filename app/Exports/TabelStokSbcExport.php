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


class TabelStokSbcExport implements FromCollection,WithTitle,ShouldAutoSize,WithHeadings,WithEvents,WithMapping
{
    private $rowNumber = 1;

    public function title(): string{
		return 'Data Welding';
	}

    public function collection()
    {
        set_time_limit(0);
        $qry = DB::table('tabel_stok_sbcs as a')
                ->select('a.part_name','a.part_no','a.job_no','a.model','a.qty_kanban','a.qty_act_ls','a.qty_act_prepare','a.customer','a.supplier','a.qty_min')
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
                $qry->qty_min,
                $qry->qty_kanban,
                $qry->qty_act_ls,
                $qry->qty_act_prepare,
                $qry->customer,
                $qry->supplier,
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
            "Qty Minimal",
            "Qty/Kanban",
            "Qty Line Store",
            "Stok PC-STORE",
            "Costumer",
            "Suppplier",
            "Category"]
        ] ;
    }

    public function registerEvents(): array
	{
		return [
			AfterSheet::class    => function(AfterSheet $event) {
				$cellRange = 'A1';
				$cellRange1 = 'A3:M3';
				$event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(18)->setBold(true);
				$event->sheet->getDelegate()->getStyle($cellRange1)->getFont()->setSize(12)->setBold(true);
                $event->sheet->mergeCells("A1:M1");
			},
		];
	}
}
