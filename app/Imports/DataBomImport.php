<?php

namespace App\Imports;

use App\Models\TabelBom;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class DataBomImport implements ToCollection, WithStartRow
{
    private $currentParent = null;

    public function startRow(): int
    {
        return 2;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // Mapping indices (0-based)
            // 0: Category, 1: No Main, 2: No Sub, 3: Job No, 4: Unique No, 5: Part Name, 6: Part Number, 7: Customer, 8: Model

            $category = $row[0];
            $noMain = $row[1];
            $noSub = $row[2];
            $jobNo = $row[3];
            $uniqueNo = $row[4];
            $partName = $row[5];
            $partNumber = $row[6];
            $customer = $row[7];
            $model = $row[8];
            $vendor = $row[9];

            // If No Main is present, this is a Mother Part definition or a Mother Part row
            if (!empty($noMain)) {
                $catName = strtoupper(trim($category));
                $catId = 1; // Default to SUB ASSY
                if ($catName == 'DIRECT' || $catName == '2') {
                    $catId = 2;
                } elseif ($catName == 'SUB ASSY' || $catName == '1') {
                    $catId = 1;
                }

                $this->currentParent = [
                    'category_id' => $catId,
                    'job_no' => $jobNo,
                    'part_no' => $partNumber,
                    'uniqNo' => $uniqueNo,
                    'part_name' => $partName,
                    'model_id' => $model,
                    'vendor' => $vendor,
                    'customer' => $customer
                ];

                TabelBom::create([
                    'category_id' => $this->currentParent['category_id'],
                    'job_no' => $this->currentParent['job_no'],
                    'part_no' => $this->currentParent['part_no'],
                    'uniqNo' => $this->currentParent['uniqNo'],
                    'part_name' => $this->currentParent['part_name'],
                    'model_id' => $this->currentParent['model_id'],
                    'vendor' => $this->currentParent['vendor'],
                    'customer' => $this->currentParent['customer'],
                    'part_no2' => $jobNo,
                    'part_name2' => $partName,
                    'createdby' => auth()->user()->id ?? 1
                ]);
            }
            // If No Sub is present, it's a child of the current parent
            else if (!empty($noSub) && $this->currentParent) {
                TabelBom::create([
                    'category_id' => $this->currentParent['category_id'],
                    'job_no' => $this->currentParent['job_no'],
                    'part_no' => $this->currentParent['part_no'],
                    'uniqNo' => $uniqueNo,
                    'part_name' => $this->currentParent['part_name'],
                    'model_id' => $this->currentParent['model_id'],
                    'vendor' => $this->currentParent['vendor'],
                    'customer' => $this->currentParent['customer'],
                    'part_no2' => $jobNo,
                    'part_name2' => $partName,
                    'createdby' => auth()->user()->id ?? 1
                ]);
            }
        }
    }
}
