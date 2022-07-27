<?php

namespace App\Imports;

use App\Models\Product;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;

class ProductImport implements ToModel, WithHeadingRow, WithStartRow, WithCustomCsvSettings
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function startRow(): int
    {
        return 2;
    }

    public function getCsvSettings(): array
    {
        return [
            'delimiter' => ','
        ];
    }
    public function model(array $row)
    {
        
            $checkIfProductExists = Product::where('name', $row['name'])->where('catagory', $row['catagory'])->exists();
            if ($checkIfProductExists == true) {
                $check = Product::where('name', $row['name'])->where('catagory', $row['catagory'])->value('quantity');
                $exist_quantity = $row['quantity'];
                $increment_quantity = $exist_quantity + $check;
              $insert = Product::where('name', $row['name'])->where('catagory', $row['catagory'])->update(['quantity' => $increment_quantity]);

            } else {
                return new Product([
                    'name'     => $row['name'],
                    'catagory'    => $row['catagory'],
                    'quantity' => $row['quantity'],
                ]);
            }
       // }
    }
}
