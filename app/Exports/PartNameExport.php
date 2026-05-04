<?php

namespace App\Exports;
use DB;
use App\Models\DataPartName;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithMapping;


class PartNameExport implements FromCollection,WithTitle,ShouldAutoSize,WithHeadings,WithEvents,WithMapping
{


    protected $lineFilter;

    public function __construct($lineFilter)
    {
        $this->lineFilter = $lineFilter;
    }



    private $rowNumber = 1;

    public function title(): string{
		return 'Data Part Name';
	}

    public function collection()
    {
        // Pisahkan line berdasarkan koma
        $lines = explode(',', $this->lineFilter);

        // Ambil data berdasarkan filter
        return DataPartName::whereIn('home_line', $lines)->get();
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
                $qry->home_line,
                $qry->customer
            ],

        ];

    }

    public function headings(): array
    {
        return [
            ["Data Part Name"],
            [""],
            ["No",
            "Part Name", 
            "Part No",
            "Job No",
            "Model",
            "Home Line",
            "Customer"]
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