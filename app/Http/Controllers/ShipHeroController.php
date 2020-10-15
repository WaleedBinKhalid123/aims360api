<?php

namespace App\Http\Controllers;

use App\Http\Services\Aims360\AimsStyleService;
use GuzzleHttp\Client;
use App\Models\QraphQlProduct;
use Illuminate\Http\Request;
use App\Models\Aims360_Product;
use App\Models\ShipHero_Aims360;
use DataTables;

class ShipHeroController extends Controller
{
    /**
     * AimsStyleServiceVariable
     *
     * @var
     */
    public $service;

    const AIMS360_STYLE_ENDPOINTS = '/StyleColors/v1.1/StyleColors';

    public $httpClient;

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
     * return graphql shiphero products view
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        return view('api.sh_products');
    }

    public function loadData()
    {
        $products = QraphQlProduct::latest()->get();
        return datatables()->of( $products )->toJson();
    }

    /**
     * get shiphero products from api
     *
     * @return \Illuminate\Http\RedirectResponse
     *
     */
     public function get()
     {
         // Query Example
         $query = <<<'QUERY'
            query {
                products {
                    complexity
                    request_id
                    data(first: 10) {
                        edges {
                            node {
                                id
                                sku
                                name
                            }
                        }
                    }
                }
            }
            QUERY;

         $options = [
             'json' => [
                 'query' => $query,
             ],
         ];

         $res = $this->service->setHeaders(['Authorization: Bearer '.$this->service->token()])->post('https://public-api.shiphero.com/graphql?'.http_build_query($options['json']));
         return $this->addProducts($res);
     }

    /**
     *
     * save graphql shiphero api products
     *
     * @param $products
     * @return \Illuminate\Http\RedirectResponse
     *
     */
     public function addProducts($products)
     {
         $count = count($products['data']->products->data->edges);
         for($i=0;$i<$count;$i++)
         {
             $graphql_products = new QraphQlProduct;
             $flag1 = $graphql_products::where('GQL_id', $products['data']->products->data->edges[$i]->node->id)->first();
             $flag2 = $graphql_products::where('sku', $products['data']->products->data->edges[$i]->node->sku)->first();
             if(!$flag1 && !$flag2)
             {
                 $graphql_products->GQL_id = $products['data']->products->data->edges[$i]->node->id;
                 $graphql_products->name = $products['data']->products->data->edges[$i]->node->name;
                 $graphql_products->sku = $products['data']->products->data->edges[$i]->node->sku;
                 $graphql_products->save();
             }
         }
         return redirect()->back();
     }

    /**
     * return shiphero product to edit
     *
     * @param Request $request
     *
     */
     public function getProduct(Request $request)
     {
         $data = QraphQlProduct::where('id', $request->id)->first();

         $form = " <form action='sh_products/submit' method='get'>
		  <div class='form-group'>
		    <label for='ID'>ID:</label>
		    <input type='text' class='form-control' id='id' name='id' value='$data->GQL_id' required>
		  </div>
		  <div class='form-group'>
		    <label for='Name'>Name:</label>
		    <input type='text' class='form-control' id='name' name='name' value='$data->name' required>
		  </div>
		  <div class='form-group'>
		    <label for='Sku'>Sku:</label>
		    <input type='text' class='form-control' id='sku' name='sku' value='$data->sku' required>
		  </div>
		  <button type='submit' class='btn btn-primary'>Submit</button>
		</form>";
         echo json_encode($form);
     }


    /**
     * edit shiphero product
     *
     * @param Request $request
     * @return mixed
     *
     */
     public function editProduct(Request $request)
     {
         QraphQlProduct::where('GQL_id', $request->input('id'))
             ->update(['GQL_id' => $request->input('id'),'name' => $request->input('name'),'sku' => $request->input('sku')]);
         return back()->withStatus('Product edit successfully');
     }

    /**
     * delete shiphero product
     *
     * @param Request $request
     *
     */
     public function deleteProduct(Request $request)
     {
         $product = QraphQlProduct::find($request->id);
         $product->delete();
         $flag = 'Done';
         echo json_encode($flag);
     }

    /**
     *
     *return all unmatch aims360 products
     */
    public function fetchShipHeroProducts()
    {
        $products = Aims360_Product::latest()->where('status','0')->get();
        return datatables()->of( $products )->toJson();
    }

    /**
     * match aims360 and shiphero product
     *
     * @param Request $request
     */
    public function matchProducts(Request $request)
    {
//      Aims360_Product::where('id', $request->id)
//            ->update(['status' => '1']);
        $aimsproduct = Aims360_Product::where('id', $request->id)->first();
        $aimsproduct->status = '1';
        $aimsproduct->save();

//        QraphQlProduct::where('id', $request->id1)
//            ->update(['status' => '1']);
        $shipheroProduct = QraphQlProduct::where('id', $request->id1)->first();
        $shipheroProduct->status = '1';
        $shipheroProduct->save();

        $ship_aim = new ShipHero_Aims360;
        $ship_aim->QraphQlProducts_id = $request->id1;
        $ship_aim->Aims360Products_id = $request->id;
        $ship_aim->GQL_id = $shipheroProduct->GQL_id;
        $ship_aim->name = $shipheroProduct->name;
        $ship_aim->sku = $shipheroProduct->sku;
        $ship_aim->styleColorID = $aimsproduct->styleColorID;
        $ship_aim->style = $aimsproduct->style;
        $ship_aim->color = $aimsproduct->color;
        $ship_aim->save();
        $flag = 'Done';
        echo json_encode($flag);
    }
}
