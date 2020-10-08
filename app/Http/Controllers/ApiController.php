<?php

namespace App\Http\Controllers;

use App\Http\Services\Aims360\AimsStyleService;
use App\Models\Shiphero_Products;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use App\Models\QraphQlProduct;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    /**
     * AimsStyleServiceVariable
     *
     * @var
     */
     public $service;

     const AIMS360_STYLE_ENDPOINTS = '/StyleColors/v1.1/StyleColors';

     public $httpClient;

     public function index()
     {
         $products = QraphQlProduct::all();
         return view('api.sh_products')->with('products',$products);
     }

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
     * get aims360 styles
     *
     * @return mixed
     */
     public function getStyles()
     {
//         dd($this->service->getBaseUri().self::AIMS360_STYLE_ENDPOINTS);
         //$res = $this->service->setHeaders($this->service->getApiBearerToken())->post($this->service->getBaseUri().self::AIMS360_STYLE_ENDPOINTS);
         //dd($res);
         return $this->service->getAims360Styles();
     }

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
//
         $options = [
//             'headers' => [
//                 'Authorization' => 'Bearer '.$this->service->getToken(),
//             ],

             'json' => [
                 'query' => $query,
             ],
         ];
//
//         try {
//             $response = $this->httpClient->request('POST', 'https://public-api.shiphero.com/graphql', $options);
//         } catch (GuzzleException $e) {
//             throw new \RuntimeException('Network Error.' . $e->getMessage(), 0, $e);
//         }
//         echo $response->getBody();

         $res = $this->service->setHeaders(['Authorization: Bearer '.$this->service->token()])->post('https://public-api.shiphero.com/graphql?'.http_build_query($options['json']));
         return $this->addProducts($res);
     }

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
         $products = QraphQlProduct::all();
         return view('api.sh_products')->with('products',$products);
     }

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

     public function editProduct(Request $request)
     {
         QraphQlProduct::where('GQL_id', $request->input('id'))
             ->update(['GQL_id' => $request->input('id'),'name' => $request->input('name'),'sku' => $request->input('sku')]);
         return back()->withStatus('Product edit successfully');
     }

     public function deleteProduct(Request $request)
     {
         $product = QraphQlProduct::find($request->id);
         $product->delete();
         $flag = 'Done';
         echo json_encode($flag);
     }
}
