<?php

namespace App\Exports;

use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;

class ItemsOutExport implements FromCollection, WithTitle, ShouldAutoSize, WithHeadings, WithEvents, WithMapping
{
    protected $startDate;
    protected $endDate;
    protected $barangId;

    private $rowNumber = 1;

    public function __construct($startDate, $endDate, $barangId = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->barangId = $barangId;
    }

    public function title(): string
    {
        return 'Data Total Item-Out ASI-1';
    }

    public function collection()
    {
        set_time_limit(0);

        $qry = DB::table('str_outs as a')
            ->select(
                'a.qty_out',
                'b.name as satuan',
                'a.date_plan',
                'c.name as item_id',
                'a.id as id',
                'd.name_dept as line_id',
                'a.price_item',
                'a.keterangan'
            )
            ->leftJoin('str_uoms as b', 'b.id', '=', 'a.satuan')
            ->leftJoin('master_list_strs as c', 'c.id', '=', 'a.item_id')
            ->leftJoin('departements as d', 'd.id', '=', 'a.line_id')
            ->whereBetween('a.date_plan', [$this->startDate, $this->endDate]);

        if ($this->barangId) {
            $qry->where('a.item_id', $this->barangId);
        }

        return collect($qry->get());
    }

    public function map($qry): array
    {
        return [
            $this->rowNumber++,
            $qry->line_id,
            $qry->item_id,
            $qry->qty_out,
            $qry->satuan,
            $qry->date_plan,
            "Rp. " . number_format($qry->price_item * 1000, 0, ',', '.'),
            $qry->keterangan,
        ];
    }

    public function headings(): array
    {
        return [
            ["Data Total Item-Out ASI-1"],
            [""],
            [
                "No",
                "Dept",
                "Nama Barang",
                "Qty Out",
                "Satuan",
                "Tanggal",
                "Harga",
                "Description"
            ]
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {

                // Merge title
                $event->sheet->mergeCells("A1:H1");

                // Title style
                $event->sheet->getDelegate()->getStyle('A1')->getFont()->setSize(18)->setBold(true);

                // Header style
                $event->sheet->getDelegate()->getStyle('A3:H3')->getFont()->setBold(true);
                $event->sheet->getDelegate()->getStyle('A3:H3')
                    ->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $event->sheet->getDelegate()->getStyle('A3:H3')
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setRGB('D3D3D3');

                // Background hijau untuk kolom harga (G)
                $event->sheet->getDelegate()->getStyle('G4:G' . ($event->sheet->getHighestRow()))
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setRGB('90EE90');

                // Border
                $event->sheet->getDelegate()->getStyle('A3:H' . $event->sheet->getHighestRow())
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                // Filter
                $event->sheet->getDelegate()->setAutoFilter('A3:H' . $event->sheet->getHighestRow());

                // Auto size
                foreach (range('A', 'H') as $columnID) {
                    $event->sheet->getColumnDimension($columnID)->setAutoSize(true);
                }
            },
        ];
    }
}