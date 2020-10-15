<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shiphero_Products;
use App\Imports\ProductsImport;
use Excel;
use Illuminate\Support\Facades\DB;
use App\Models\Aims360_Product;
use App\Models\QraphQlProduct;
use App\Models\ShipHero_Aims360;

class DashboardController extends Controller
{
    public function show()
    {
        $count = QraphQlProduct::all()->count();
        $count1 = Aims360_Product::all()->count();
        $count2 = ShipHero_Aims360::all()->count();
        $count3 = QraphQlProduct::all()->where('status','0')->count();
        $count4 = Aims360_Product::all()->where('status','0')->count();
        $counts = [];
        $counts[0] = $count;
        $counts[1] = $count1;
        $counts[2] = $count2;
        $counts[3] = $count3;
        $counts[4] = $count4;
        return view('products.dashboard')->with('counts',$counts);
    }
//    public function import(Request $request)
//    {
//    	Shiphero_Products::truncate();
//        Excel::import(new ProductsImport,$request->file);
//        return back()->withStatus('Excel file imported Successfully');
//    }
//     public function add(Request $request)
//    {
//    	$data = Shiphero_Products::where('SKU', $request->input('sku'))->first();
//    	//dd($data);
//        if(empty($data))
//        {
//    		$product = new Shiphero_Products();
//    		$product->style = $request->input('style');
//    		$product->color = $request->input('color');
//    		$product->sizenum = $request->input('sizenum');
//    		$product->sizedesc = $request->input('sizedesc');
//    		$product->SKU = $request->input('sku');
//    		$product->save();
//    		return back()->withStatus('Product added Successfully');
//    	}
//    	else
//    	{
//    		return back()->withStatus('Product SKU already exist');
//    	}
//    }
//    public function get(Request $request)
//    {
//    	$data = Shiphero_Products::where('id', $request->id)->first();
//
//    	$form = " <form action='import/getProduct' method='get'>
//		  <div class='form-group'>
//		    <label for='style'>Style:</label>
//		    <input type='text' class='form-control' id='style' name='style' value='$data->style' required>
//		  </div>
//		  <div class='form-group'>
//		    <label for='color'>Color:</label>
//		    <input type='text' class='form-control' id='color' name='color' value='$data->color' required>
//		  </div>
//		  <div class='form-group'>
//		    <label for='sizenum'>SizeNum:</label>
//		    <input type='text' class='form-control' id='sizenum' name='sizenum' value='$data->sizenum' required>
//		  </div>
//		  <div class='form-group'>
//		    <label for='sizedesc'>SizeDesc:</label>
//		    <input type='text' class='form-control' id='sizedesc' name='sizedesc' value='$data->sizedesc' required>
//		  </div>
//		  <div class='form-group'>
//		    <label for='sku'>ShipHero_SKU:</label>
//		    <input type='text' class='form-control' id='sku' name='sku' value='$data->SKU' required>
//		  </div>
//		  <button type='submit' class='btn btn-primary'>Submit</button>
//		</form>";
//    	echo json_encode($form);
//    }
//    public function edit(Request $request)
//    {
//    	Shiphero_Products::where('SKU', $request->input('sku'))
//          ->update(['style' => $request->input('style'),'color' => $request->input('color'),'sizenum' => $request->input('sizenum'),'sizedesc' => $request->input('sizedesc'),'SKU' => $request->input('sku')]);
//          return back()->withStatus('Product edit successfully');
//    }
//    public function del(Request $request)
//    {
//    	$product = Shiphero_Products::find($request->id);
//        $product->delete();
//        $flag = 'Done';
//        echo json_encode($flag);
//    }
}

