<?php

namespace App\Http\Controllers;

use App\Models\Aims360_Product;
use App\Models\QraphQlProduct;
use App\Models\ShipHero_Aims360;
use App\Models\Shiphero_Products;
use Illuminate\Http\Request;

class MatchProductController extends Controller
{
    public function index()
    {
        return view('api.match_products');
    }

    public function loadMatchProducts()
    {
        $products = ShipHero_Aims360::latest()->get();
        return datatables()->of( $products )->toJson();
    }
    public function unMatchProduct(Request $request)
    {
        QraphQlProduct::where('id', $request->shipHeroId)
            ->update(['status' => '0']);
        Aims360_Product::where('id', $request->aims360Id)
           ->update(['status' => '0']);
        $product = ShipHero_Aims360::where('id',$request->id)->first();
        $product->delete();
        $flag = 'Done';
        echo json_encode($flag);
    }
}
