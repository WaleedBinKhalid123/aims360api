<?php

namespace App\Imports;

use App\Models\Shiphero_Products;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
            return new Shiphero_Products([
            "id" => $row["id"]??Null,
            "style" => $row["style"],
            "color" => $row["color"],
            "sizenum" => $row["sizenum"],
            "sizedesc" => $row["sizedesc"],
            "SKU" => $row["sku"]
        ]);
    }
}
