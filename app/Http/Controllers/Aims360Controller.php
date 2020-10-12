<?php

namespace App\Http\Controllers;

use App\Http\Services\Aims360\AimsStyleService;
use App\Models\Aims360_Product;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class Aims360Controller extends Controller
{

    /**
     * instantiate AimsStyleService object
     *
     * ApiController constructor.
     */
    public function __construct()
    {
        $this->httpClient = new Client();
        $this->service = new AimsStyleService();
    }

    /**
     * return aims360 product view
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $products = Aims360_Product::all();
        return view('api.A360_products')->with('products',$products);
    }

    /**
     * return form with specific product to edit
     *
     * @param Request $request
     *
     */
    public function getProduct(Request $request)
    {
        $data = Aims360_Product::where('id', $request->id)->first();

        $form = " <form action='A360_products/submit' method='get'>
		  <div class='form-group'>
		    <label for='ID'>StyleColorID:</label>
		    <input type='text' class='form-control' id='id' name='id' value='$data->styleColorID' required>
		  </div>
		  <div class='form-group'>
		    <label for='Style'>Style:</label>
		    <input type='text' class='form-control' id='style' name='style' value='$data->style' required>
		  </div>
		  <div class='form-group'>
		    <label for='Color'>Color:</label>
		    <input type='text' class='form-control' id='color' name='color' value='$data->color' required>
		  </div>
		  <div class='form-group'>
		    <label for='Desc'>Description:</label>
		    <input type='text' class='form-control' id='desc' name='desc' value='$data->description' required>
		  </div>
		  <button type='submit' class='btn btn-primary'>Submit</button>
		</form>";
        echo json_encode($form);
    }

    /**
     * Edit Aims360 product
     *
     * @param Request $request
     * @return mixed
     *
     */
    public function editProduct(Request $request)
    {
        Aims360_Product::where('styleColorID', $request->input('id'))
            ->update(['styleColorID' => $request->input('id'), 'style' => $request->input('style'), 'color' => $request->input('color'), 'description' => $request->input('desc')]);
        return back()->withStatus('Product edit successfully');
    }


    /**
     * Delete Aims360 Product
     *
     * @param Request $request
     *
     */
    public function deleteProduct(Request $request)
    {
        $product = Aims360_Product::find($request->id);
        $product->delete();
        $flag = 'Done';
        echo json_encode($flag);
    }

    /**
     * get aims360 api styles
     *
     * @return mixed
     */
    public function getStyles()
    {
        $this->service->getAims360Styles();
        return redirect()->back();
    }


}