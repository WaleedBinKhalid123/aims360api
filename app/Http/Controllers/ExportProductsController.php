<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shiphero_Products;
use Excel;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportProductsController extends Controller
{
    //
    public function export()
    {
    	return Excel::download(new ProductsExport, 'ShipHero_Products.xlsx');
    } 
}

class ProductsExport implements FromCollection
{
	public function collection()
	{
		return Shiphero_Products::all();
	} 
}