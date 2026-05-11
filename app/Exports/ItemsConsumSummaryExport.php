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

class ItemsConsumSummaryExport implements 
    FromCollection,
    WithTitle,
    ShouldAutoSize,
    WithHeadings,
    WithEvents,
    WithMapping
{
    protected $startDate;
    protected $endDate;

    private $rowNumber = 1;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate   = $endDate;
    }

    public function title(): string
    {
        return 'Summary Consumable Stok';
    }

    public function collection()
    {
        set_time_limit(0);

        $start = $this->startDate;
        $end   = $this->endDate;

        $qry = DB::table('str_stok_consums as a')
            ->select(
                'a.category',
                'a.actual',
                'a.minimal',
                'c.name as item_name',
                'c.price',
                'b.name as satuan',

                // Barang Masuk
                DB::raw("(SELECT COALESCE(SUM(x.qty_in),0)
                          FROM str_ins x 
                          WHERE x.item_id = a.item_id
                          AND x.category_id = 3
                          AND DATE(x.date_plan) BETWEEN '$start' AND '$end'
                ) as barang_masuk"),

                // Barang Keluar Manual
                DB::raw("(SELECT COALESCE(SUM(y.qty_out),0)
                          FROM str_outs y
                          JOIN str_barangs z ON z.id = y.item_id
                          WHERE y.item_id = a.item_id
                          AND z.category = 3
                          AND DATE(y.date_plan) BETWEEN '$start' AND '$end'
                ) as barang_keluar"),

                // Barang Keluar E-SPB
                DB::raw("(
                    (SELECT COALESCE(SUM(o2.qty_request),0) FROM str_out2s o2 WHERE o2.item_id = a.item_id AND DATE(o2.date_plan) BETWEEN '$start' AND '$end')
                  + (SELECT COALESCE(SUM(o3.qty_request),0) FROM str_out3s o3 WHERE o3.item_id = a.item_id AND DATE(o3.date_plan) BETWEEN '$start' AND '$end')
                  + (SELECT COALESCE(SUM(o4.qty_request),0) FROM str_out4s o4 WHERE o4.item_id = a.item_id AND DATE(o4.date_plan) BETWEEN '$start' AND '$end')
                  + (SELECT COALESCE(SUM(o5.qty_request),0) FROM str_out5s o5 WHERE o5.item_id = a.item_id AND DATE(o5.date_plan) BETWEEN '$start' AND '$end')
                  + (SELECT COALESCE(SUM(o6.qty_request),0) FROM str_out6s o6 WHERE o6.item_id = a.item_id AND DATE(o6.date_plan) BETWEEN '$start' AND '$end')
                  + (SELECT COALESCE(SUM(o7.qty_request),0) FROM str_out7s o7 WHERE o7.item_id = a.item_id AND DATE(o7.date_plan) BETWEEN '$start' AND '$end')
                  + (SELECT COALESCE(SUM(o8.qty_request),0) FROM str_out8s o8 WHERE o8.item_id = a.item_id AND DATE(o8.date_plan) BETWEEN '$start' AND '$end')
                  + (SELECT COALESCE(SUM(o9.qty_request),0) FROM str_out9s o9 WHERE o9.item_id = a.item_id AND DATE(o9.date_plan) BETWEEN '$start' AND '$end')
                  + (SELECT COALESCE(SUM(o10.qty_request),0) FROM str_out10s o10 WHERE o10.item_id = a.item_id AND DATE(o10.date_plan) BETWEEN '$start' AND '$end')
                  + (SELECT COALESCE(SUM(o11.qty_request),0) FROM str_out11s o11 WHERE o11.item_id = a.item_id AND DATE(o11.date_plan) BETWEEN '$start' AND '$end')
                  + (SELECT COALESCE(SUM(o12.qty_request),0) FROM str_out12s o12 WHERE o12.item_id = a.item_id AND DATE(o12.date_plan) BETWEEN '$start' AND '$end')
                  + (SELECT COALESCE(SUM(o13.qty_request),0) FROM str_out13s o13 WHERE o13.item_id = a.item_id AND DATE(o13.date_plan) BETWEEN '$start' AND '$end')
                  + (SELECT COALESCE(SUM(o14.qty_request),0) FROM str_out14s o14 WHERE o14.item_id = a.item_id AND DATE(o14.date_plan) BETWEEN '$start' AND '$end')
                  + (SELECT COALESCE(SUM(o15.qty_request),0) FROM str_out15s o15 WHERE o15.item_id = a.item_id AND DATE(o15.date_plan) BETWEEN '$start' AND '$end')
                  + (SELECT COALESCE(SUM(o16.qty_request),0) FROM str_out16s o16 WHERE o16.item_id = a.item_id AND DATE(o16.date_plan) BETWEEN '$start' AND '$end')
                  + (SELECT COALESCE(SUM(o17.qty_request),0) FROM str_out17s o17 WHERE o17.item_id = a.item_id AND DATE(o17.date_plan) BETWEEN '$start' AND '$end')
                  + (SELECT COALESCE(SUM(o18.qty_request),0) FROM str_out18s o18 WHERE o18.item_id = a.item_id AND DATE(o18.date_plan) BETWEEN '$start' AND '$end')
                
                ) as barang_keluar2"),

                // Qty Return
                DB::raw("(
                    (SELECT COALESCE(SUM(r2.qty_return),0) FROM str_out2s r2 WHERE r2.item_id = a.item_id AND DATE(r2.date_plan) BETWEEN '$start' AND '$end')
                  + (SELECT COALESCE(SUM(r3.qty_return),0) FROM str_out3s r3 WHERE r3.item_id = a.item_id AND DATE(r3.date_plan) BETWEEN '$start' AND '$end')
                  + (SELECT COALESCE(SUM(r4.qty_return),0) FROM str_out4s r4 WHERE r4.item_id = a.item_id AND DATE(r4.date_plan) BETWEEN '$start' AND '$end')
                  + (SELECT COALESCE(SUM(r5.qty_return),0) FROM str_out5s r5 WHERE r5.item_id = a.item_id AND DATE(r5.date_plan) BETWEEN '$start' AND '$end')
                  + (SELECT COALESCE(SUM(r6.qty_return),0) FROM str_out6s r6 WHERE r6.item_id = a.item_id AND DATE(r6.date_plan) BETWEEN '$start' AND '$end')
                  + (SELECT COALESCE(SUM(r7.qty_return),0) FROM str_out7s r7 WHERE r7.item_id = a.item_id AND DATE(r7.date_plan) BETWEEN '$start' AND '$end')
                  + (SELECT COALESCE(SUM(r8.qty_return),0) FROM str_out8s r8 WHERE r8.item_id = a.item_id AND DATE(r8.date_plan) BETWEEN '$start' AND '$end')
                  + (SELECT COALESCE(SUM(r9.qty_return),0) FROM str_out9s r9 WHERE r9.item_id = a.item_id AND DATE(r9.date_plan) BETWEEN '$start' AND '$end')
                  + (SELECT COALESCE(SUM(r10.qty_return),0) FROM str_out10s r10 WHERE r10.item_id = a.item_id AND DATE(r10.date_plan) BETWEEN '$start' AND '$end')
                  + (SELECT COALESCE(SUM(r11.qty_return),0) FROM str_out11s r11 WHERE r11.item_id = a.item_id AND DATE(r11.date_plan) BETWEEN '$start' AND '$end')
                  + (SELECT COALESCE(SUM(r12.qty_return),0) FROM str_out12s r12 WHERE r12.item_id = a.item_id AND DATE(r12.date_plan) BETWEEN '$start' AND '$end')
                  + (SELECT COALESCE(SUM(r13.qty_return),0) FROM str_out13s r13 WHERE r13.item_id = a.item_id AND DATE(r13.date_plan) BETWEEN '$start' AND '$end')
                  + (SELECT COALESCE(SUM(r14.qty_return),0) FROM str_out14s r14 WHERE r14.item_id = a.item_id AND DATE(r14.date_plan) BETWEEN '$start' AND '$end')
                  + (SELECT COALESCE(SUM(r15.qty_return),0) FROM str_out15s r15 WHERE r15.item_id = a.item_id AND DATE(r15.date_plan) BETWEEN '$start' AND '$end')
                  + (SELECT COALESCE(SUM(r16.qty_return),0) FROM str_out16s r16 WHERE r16.item_id = a.item_id AND DATE(r16.date_plan) BETWEEN '$start' AND '$end')
                  + (SELECT COALESCE(SUM(r17.qty_return),0) FROM str_out17s r17 WHERE r17.item_id = a.item_id AND DATE(r17.date_plan) BETWEEN '$start' AND '$end')
                  + (SELECT COALESCE(SUM(r18.qty_return),0) FROM str_out18s r18 WHERE r18.item_id = a.item_id AND DATE(r18.date_plan) BETWEEN '$start' AND '$end')
                 
               
                ) AS qty_return"),

                // Qty Out (Total request)
                DB::raw("(
                    (SELECT COALESCE(SUM(o2.qty_request),0) FROM str_out2s o2 WHERE o2.item_id = a.item_id AND DATE(o2.date_plan) BETWEEN '$start' AND '$end')
                  + (SELECT COALESCE(SUM(o3.qty_request),0) FROM str_out3s o3 WHERE o3.item_id = a.item_id AND DATE(o3.date_plan) BETWEEN '$start' AND '$end')
                  + (SELECT COALESCE(SUM(o4.qty_request),0) FROM str_out4s o4 WHERE o4.item_id = a.item_id AND DATE(o4.date_plan) BETWEEN '$start' AND '$end')
                  + (SELECT COALESCE(SUM(o5.qty_request),0) FROM str_out5s o5 WHERE o5.item_id = a.item_id AND DATE(o5.date_plan) BETWEEN '$start' AND '$end')
                  + (SELECT COALESCE(SUM(o6.qty_request),0) FROM str_out6s o6 WHERE o6.item_id = a.item_id AND DATE(o6.date_plan) BETWEEN '$start' AND '$end')
                  + (SELECT COALESCE(SUM(o7.qty_request),0) FROM str_out7s o7 WHERE o7.item_id = a.item_id AND DATE(o7.date_plan) BETWEEN '$start' AND '$end')
                  + (SELECT COALESCE(SUM(o8.qty_request),0) FROM str_out8s o8 WHERE o8.item_id = a.item_id AND DATE(o8.date_plan) BETWEEN '$start' AND '$end')
                  + (SELECT COALESCE(SUM(o9.qty_request),0) FROM str_out9s o9 WHERE o9.item_id = a.item_id AND DATE(o9.date_plan) BETWEEN '$start' AND '$end')
                  + (SELECT COALESCE(SUM(o10.qty_request),0) FROM str_out10s o10 WHERE o10.item_id = a.item_id AND DATE(o10.date_plan) BETWEEN '$start' AND '$end')
                  + (SELECT COALESCE(SUM(o11.qty_request),0) FROM str_out11s o11 WHERE o11.item_id = a.item_id AND DATE(o11.date_plan) BETWEEN '$start' AND '$end')
                  + (SELECT COALESCE(SUM(o12.qty_request),0) FROM str_out12s o12 WHERE o12.item_id = a.item_id AND DATE(o12.date_plan) BETWEEN '$start' AND '$end')
                  + (SELECT COALESCE(SUM(o13.qty_request),0) FROM str_out13s o13 WHERE o13.item_id = a.item_id AND DATE(o13.date_plan) BETWEEN '$start' AND '$end')
                  + (SELECT COALESCE(SUM(o14.qty_request),0) FROM str_out14s o14 WHERE o14.item_id = a.item_id AND DATE(o14.date_plan) BETWEEN '$start' AND '$end')
                  + (SELECT COALESCE(SUM(o15.qty_request),0) FROM str_out15s o15 WHERE o15.item_id = a.item_id AND DATE(o15.date_plan) BETWEEN '$start' AND '$end')
                  + (SELECT COALESCE(SUM(o16.qty_request),0) FROM str_out16s o16 WHERE o16.item_id = a.item_id AND DATE(o16.date_plan) BETWEEN '$start' AND '$end')
                  + (SELECT COALESCE(SUM(o17.qty_request),0) FROM str_out17s o17 WHERE o17.item_id = a.item_id AND DATE(o17.date_plan) BETWEEN '$start' AND '$end')
                  + (SELECT COALESCE(SUM(o18.qty_request),0) FROM str_out18s o18 WHERE o18.item_id = a.item_id AND DATE(o18.date_plan) BETWEEN '$start' AND '$end')
               
                ) AS qty_out")
            )
            ->leftJoin('str_uoms as b', 'b.id', '=', 'a.satuan')
            ->leftJoin('str_barangs as c', 'c.id', '=', 'a.item_id')
            ->orderBy('c.name')
            ->get();

        return collect($qry);
    }

    public function map($qry): array
    {
        $periode = $this->startDate . " s/d " . $this->endDate;

        $price            = floatval($qry->price ?? 0);
        $barang_keluar    = floatval($qry->barang_keluar ?? 0);
        $barang_keluar2   = floatval($qry->barang_keluar2 ?? 0);
        $qty_return       = floatval($qry->qty_return ?? 0);
        $qty_out          = floatval($qry->qty_out ?? 0);

        $total_price1 = $barang_keluar * $price;
        $total_price2 = $barang_keluar2 * $price;

        return [
            $this->rowNumber++,
            $qry->item_name,
            $qry->satuan,
            number_format($price, 3, '.', ''),
            $qry->actual,
            $qry->minimal,
            $qry->barang_masuk,
            $qry->barang_keluar,
            number_format($total_price1, 3, '.', ''),
            $qry->barang_keluar2,
            $qty_return,
            $qty_out,
            number_format($total_price2, 3, '.', ''),
            $periode
        ];
    }

    public function headings(): array
    {
        return [
            ["Data Summary Stok Consumable"],
            [""],
            [""],
            [
                "No",
                "Item Name",
                "Unit",
                "Price",
                "Actual",
                "Minimal",
                "Incoming Goods",
                "Outgoing Goods (SPB Manual)",
                "Total Price Manual",
                "Outgoing Goods (E-SPB)",
                "Qty Return E-SPB",
                "Qty Out E-SPB",
                "Total Price E-SPB",
                "Periode"
            ]
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {

                $sheet = $event->sheet->getDelegate();

                // Title
                $sheet->mergeCells('A1:N1');
                $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(18);

                // Header Styling
                $sheet->getStyle('A4:N4')->getFont()->setBold(true);
                $sheet->getStyle('A4:N4')
                    ->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setRGB('D3D3D3');

                $sheet->getStyle('D5:D' . $sheet->getHighestRow())
                    ->getNumberFormat()->setFormatCode('"Rp." #,##0.000');
                

                // Number Format Total Price
                $sheet->getStyle('I5:I' . $sheet->getHighestRow())
                  ->getNumberFormat()->setFormatCode('"Rp." #,##0.000');

                    
                // Number Format Total Price
                $sheet->getStyle('M5:M' . $sheet->getHighestRow())
              ->getNumberFormat()->setFormatCode('"Rp." #,##0.000');

                // Coloring for Qty Return & Qty Out

                $sheet->getStyle('D5:D' . $sheet->getHighestRow())
                    ->getFill()->setFillType('solid')->getStartColor()->setRGB('CCFFCC');
                $sheet->getStyle('J5:J' . $sheet->getHighestRow())
                    ->getFill()->setFillType('solid')->getStartColor()->setRGB('FFE5CC');
                $sheet->getStyle('H5:H' . $sheet->getHighestRow())
                    ->getFill()->setFillType('solid')->getStartColor()->setRGB('FFE5CC');
                $sheet->getStyle('I5:I' . $sheet->getHighestRow())
                ->getFill()->setFillType('solid')->getStartColor()->setRGB('CCFFCC');
                $sheet->getStyle('J5:J' . $sheet->getHighestRow())
                ->getFill()->setFillType('solid')->getStartColor()->setRGB('E6CCFF');
                $sheet->getStyle('K5:K' . $sheet->getHighestRow())
                ->getFill()->setFillType('solid')->getStartColor()->setRGB('CCFFCC');
                $sheet->getStyle('L5:L' . $sheet->getHighestRow())
                ->getFill()->setFillType('solid')->getStartColor()->setRGB('E6CCFF');
                $sheet->getStyle('K5:K' . $sheet->getHighestRow())
                    ->getFill()->setFillType('solid')->getStartColor()->setRGB('E6CCFF');
                    $sheet->getStyle('M5:M' . $sheet->getHighestRow())
                    ->getFill()->setFillType('solid')->getStartColor()->setRGB('CCFFCC');
                    

                // Border
                $sheet->getStyle('A4:N' . $sheet->getHighestRow())
                    ->getBorders()->getAllBorders()
                    ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                // Autosize Columns
                foreach (range('A', 'N') as $col) {
                    $sheet->getColumnDimension($col)->setAutoSize(true);
                }
            }
        ];
    }
}
