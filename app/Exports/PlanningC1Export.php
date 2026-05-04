<?php

namespace App\Exports;

use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class PlanningC1Export implements FromCollection, WithHeadings, ShouldAutoSize, WithTitle, WithEvents
{
    protected $startDate;
    protected $endDate;
    protected $mesin;

    public function __construct($startDate, $endDate, $mesin)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->mesin = $mesin;
    }

    public function collection()
    {
        $query = DB::table('planning_line_b3_s')
            ->select(
                'part_name',
                'job_no',
                'part_no2',
                'model_id',
                'qty_plan',
                'date_plan',
                'createdby',
                'shift',
                'mesin',
                'actual_production',
                'user_stamping_done',
                'time_startProses',
                'time_endProses'
            )
            ->whereBetween('created_at', [$this->startDate . ' 00:00:00', $this->endDate . ' 23:59:59']);

        if ($this->mesin === 'All') {
            $query->whereIn('mesin', ['LINE C1', 'LINE C2', 'LINE B3']);
        } else {
            $query->where('mesin', $this->mesin);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'Part Name',
            'Job No',
            'Part No 2',
            'Model ID',
            'Qty Plan',
            'Date Plan',
            'Created By',
            'Shift',
            'Mesin',
            'Actual Production',
            'User Stamping Done',
            'Time Start Proses',
            'Time End Proses'
        ];
    }

    public function title(): string
    {
        return 'Planning C1 Export';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $headerRange = 'A1:M1';
                $event->sheet->getDelegate()->getStyle($headerRange)->getFont()->setBold(true);
                $event->sheet->getDelegate()->getStyle($headerRange)->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFD9E2F3');
                
                $highestRow = $event->sheet->getDelegate()->getHighestRow();
                $highestColumn = $event->sheet->getDelegate()->getHighestColumn();
                $dataRange = 'A1:' . $highestColumn . $highestRow;
                $event->sheet->getDelegate()->getStyle($dataRange)
                    ->getBorders()->getAllBorders()
                    ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            },
        ];
    }
}
