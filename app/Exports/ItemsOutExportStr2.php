<?php

namespace App\Exports;
use DB;
// use App\Models\StrOut;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithMapping;
// use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;

class ItemsOutExportStr2 implements FromCollection,WithTitle,ShouldAutoSize,WithHeadings,WithEvents,WithMapping
{

    protected $startDate;
    protected $endDate;
    protected $barangId;

    public function __construct($startDate, $endDate, $barangId = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->barangId = $barangId;
    }

  

    private $rowNumber = 1;

    public function title(): string{
		return 'Data Total Item-Out ASI-2';
	}

    public function collection()
{
    set_time_limit(0);

    // Memulai query dengan filter tanggal
    $qry = DB::table('str2_outs as a')
            ->select('a.qty_out', 'b.name as satuan', 'a.date_plan', 'c.name as item_id', 'a.id as id', 'd.name_dept as line_id','a.price_item','a.keterangan')
            ->leftJoin('str_uoms as b', 'b.id', '=', 'a.satuan')
            ->leftJoin('str_barangs as c', 'c.id', '=', 'a.item_id')
            ->leftJoin('departements as d', 'd.id', '=', 'a.line_id')
            ->whereBetween('a.date_plan', [$this->startDate, $this->endDate]);

    // Menambahkan kondisi filter item_id jika barangId ada
    if ($this->barangId) {
        $qry->where('a.item_id', $this->barangId);
    }

    // Menjalankan query dan mengambil hasilnya
    $results = $qry->get();

    // Mengubah hasil menjadi koleksi
    return collect($results);
}
    

    public function map($qry): array
    {
        // Pastikan harga item diformat sebagai string dengan 3 angka desimal
        $priceItem = number_format((float)$qry->price_item, 3, '.', ''); // Memastikan nilai tetap memiliki 3 angka desimal
        
        return [
            [
                $this->rowNumber++,
                $qry->line_id,
                $qry->item_id,
                $qry->qty_out,
                // $qry->actual,
                $qry->satuan,
                $qry->date_plan,
                $priceItem, // Nilai dengan 3 angka desimal
                $qry->keterangan,
            ],
        ];
    }

    public function headings(): array
    {
        return [
            ["Data Total Item-Out ASI-2"],
            [""],
            ["No",
            "Dept",
            "Nama Barang", 
            "Qty Out",
            "Satuan",
            "Tanggal",
            "Harga",
            "Description"]
        ] ;								
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $cellRange = 'A1';
                $cellRange1 = 'A2:H2';
    
                // Set font for header and title
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(18)->setBold(true);
                $event->sheet->getDelegate()->getStyle($cellRange1)->getFont()->setSize(12)->setBold(true);
    
                // Merge title cells
                $event->sheet->mergeCells("A1:H1");

                  // Mengatur format angka untuk kolom harga dengan tiga angka desimal (Rupiah)
                  $event->sheet->getDelegate()->getStyle('H2:H' . ($event->sheet->getHighestRow()))
                  ->getNumberFormat()
                  ->setFormatCode('[$Rp.]#,##0.000'); // Format mata uang Rupiah (IDR) dengan 3 angka desimal tanpa spasi
    
                // Set background colors for specific columns
               // Set warna hiGau untuk kolom G (dari G5 hingga baris terakhir)
               $event->sheet->getDelegate()->getStyle('H4:H' . ($event->sheet->getHighestRow()))
               ->getFill()
               ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
               ->getStartColor()->setRGB('90EE90'); // Warna hiGau muda (LightGreen)
    
                // Add borders around data (A3 to last row in column M)
                $event->sheet->getDelegate()->getStyle('A3:H' . $event->sheet->getHighestRow())
                    ->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    
                // Set the data range as a table
                $event->sheet->getDelegate()->setAutoFilter('A3:H' . $event->sheet->getHighestRow());
    
                // Optionally, set auto size for columns
                foreach (range('A', 'H') as $columnID) {
                    $event->sheet->getColumnDimension($columnID)->setAutoSize(true);
                }
    
                // Align the headers to be centered
                $event->sheet->getDelegate()->getStyle('A3:H3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('A3:H3')->getFont()->setBold(true);
                $event->sheet->getDelegate()->getStyle('A3:H3')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('D3D3D3'); // Light Grey background for header
            },
        ];
    }
    
}