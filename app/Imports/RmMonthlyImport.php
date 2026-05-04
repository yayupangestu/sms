<?php


namespace App\Imports;

use App\Models\RmMonthly;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class RmMonthlyImport implements ToModel, WithStartRow, SkipsEmptyRows
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    
    {

        //  // Periksa apakah nilai dari kolom yang diperlukan ada
        // if (empty($row[6]) || empty($row[26])) {
        //     return null; // Jangan masukkan data jika salah satu kolom tidak ada nilai
        // }



      
        $tgl1  = isset($row[15]) ? (is_numeric($row[15]) ? number_format((float)$row[15], 2, '.', '') : $row[15]) : null;
        $tgl2  = isset($row[17]) ? (is_numeric($row[17]) ? number_format((float)$row[17], 2, '.', '') : $row[17]) : null;
        $tgl3  = isset($row[19]) ? (is_numeric($row[19]) ? number_format((float)$row[19], 2, '.', '') : $row[19]) : null;
        $tgl4  = isset($row[21]) ? (is_numeric($row[21]) ? number_format((float)$row[21], 2, '.', '') : $row[21]) : null;
        $tgl5  = isset($row[23]) ? (is_numeric($row[23]) ? number_format((float)$row[23], 2, '.', '') : $row[23]) : null;
        $tgl6  = isset($row[25]) ? (is_numeric($row[25]) ? number_format((float)$row[25], 2, '.', '') : $row[25]) : null;
        $tgl7  = isset($row[27]) ? (is_numeric($row[27]) ? number_format((float)$row[27], 2, '.', '') : $row[27]) : null;
        $tgl8  = isset($row[29]) ? (is_numeric($row[29]) ? number_format((float)$row[29], 2, '.', '') : $row[29]) : null;
        $tgl9  = isset($row[31]) ? (is_numeric($row[31]) ? number_format((float)$row[31], 2, '.', '') : $row[31]) : null;
        $tgl10 = isset($row[33]) ? (is_numeric($row[33]) ? number_format((float)$row[33], 2, '.', '') : $row[33]) : null;
        $tgl11 = isset($row[35]) ? (is_numeric($row[35]) ? number_format((float)$row[35], 2, '.', '') : $row[35]) : null;
        $tgl12 = isset($row[37]) ? (is_numeric($row[37]) ? number_format((float)$row[37], 2, '.', '') : $row[37]) : null;
        $tgl13 = isset($row[39]) ? (is_numeric($row[39]) ? number_format((float)$row[39], 2, '.', '') : $row[39]) : null;
        $tgl14 = isset($row[41]) ? (is_numeric($row[41]) ? number_format((float)$row[41], 2, '.', '') : $row[41]) : null;
        $tgl15 = isset($row[43]) ? (is_numeric($row[43]) ? number_format((float)$row[43], 2, '.', '') : $row[43]) : null;
        $tgl16 = isset($row[45]) ? (is_numeric($row[45]) ? number_format((float)$row[45], 2, '.', '') : $row[45]) : null;
        $tgl17 = isset($row[47]) ? (is_numeric($row[47]) ? number_format((float)$row[47], 2, '.', '') : $row[47]) : null;
        $tgl18 = isset($row[49]) ? (is_numeric($row[49]) ? number_format((float)$row[49], 2, '.', '') : $row[49]) : null;
        $tgl19 = isset($row[51]) ? (is_numeric($row[51]) ? number_format((float)$row[51], 2, '.', '') : $row[51]) : null;
        $tgl20 = isset($row[53]) ? (is_numeric($row[53]) ? number_format((float)$row[53], 2, '.', '') : $row[53]) : null;
        $tgl21 = isset($row[55]) ? (is_numeric($row[55]) ? number_format((float)$row[55], 2, '.', '') : $row[55]) : null;
        $tgl22 = isset($row[57]) ? (is_numeric($row[57]) ? number_format((float)$row[57], 2, '.', '') : $row[57]) : null;
        $tgl23 = isset($row[59]) ? (is_numeric($row[59]) ? number_format((float)$row[59], 2, '.', '') : $row[59]) : null;
        $tgl24 = isset($row[61]) ? (is_numeric($row[61]) ? number_format((float)$row[61], 2, '.', '') : $row[61]) : null;
        $tgl25 = isset($row[63]) ? (is_numeric($row[63]) ? number_format((float)$row[63], 2, '.', '') : $row[63]) : null;
        $tgl26 = isset($row[65]) ? (is_numeric($row[65]) ? number_format((float)$row[65], 2, '.', '') : $row[65]) : null;
        $tgl27 = isset($row[67]) ? (is_numeric($row[67]) ? number_format((float)$row[67], 2, '.', '') : $row[67]) : null;
        $tgl28 = isset($row[69]) ? (is_numeric($row[69]) ? number_format((float)$row[69], 2, '.', '') : $row[69]) : null;
        $tgl29 = isset($row[71]) ? (is_numeric($row[71]) ? number_format((float)$row[71], 2, '.', '') : $row[71]) : null;
        $tgl30 = isset($row[73]) ? (is_numeric($row[73]) ? number_format((float)$row[73], 2, '.', '') : $row[73]) : null;
        $tgl31 = isset($row[75]) ? (is_numeric($row[75]) ? number_format((float)$row[75], 2, '.', '') : $row[75]) : null;

        return new RmMonthly([
            'po_no'              => $row[1] ?? null, 
            'month'              => $row[2] ?? null, 
            'year'               => $row[3] ?? null,
            'part_no'            => $row[4] ?? null, 
            'kanban'             => $row[5] ?? null, 
            'spec'               => $row[6] ?? null, 
            'spec_t'             => $row[7] ?? null, 
            'spec_w'             => $row[8] ?? null, 
            'spec_l'             => $row[9] ?? null, 
            'po_sheet'           => $row[12] ?? null, 
            'po_kg'              => $row[13] ?? null, 
            'tgl_1'              => $tgl1,
            'tgl_2'              => $tgl2,
            'tgl_3'              => $tgl3,
            'tgl_4'              => $tgl4,
            'tgl_5'              => $tgl5,
            'tgl_6'              => $tgl6,
            'tgl_7'              => $tgl7,
            'tgl_8'              => $tgl8,
            'tgl_9'              => $tgl9,
            'tgl_10'             => $tgl10,
            'tgl_11'             => $tgl11,
            'tgl_12'             => $tgl12,
            'tgl_13'             => $tgl13,
            'tgl_14'             => $tgl14,
            'tgl_15'             => $tgl15,
            'tgl_16'             => $tgl16,
            'tgl_17'             => $tgl17,
            'tgl_18'             => $tgl18,
            'tgl_19'             => $tgl19,
            'tgl_20'             => $tgl20,
            'tgl_21'             => $tgl21,
            'tgl_22'             => $tgl22,
            'tgl_23'             => $tgl23,
            'tgl_24'             => $tgl24,
            'tgl_25'             => $tgl25,
            'tgl_26'             => $tgl26,
            'tgl_27'             => $tgl27,
            'tgl_28'             => $tgl28,
            'tgl_29'             => $tgl29,
            'tgl_30'             => $tgl30,
            'tgl_31'             => $tgl31,
         

           
      
        ]);
        
    }

    /**
     * Mulai dari baris ke-2 untuk mengabaikan header.
     */
    public function startRow(): int
    {
        return 7;
    }
}
