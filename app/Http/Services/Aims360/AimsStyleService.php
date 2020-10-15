<?php

namespace App\Http\Services\Aims360;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\Aims360_Product;

/**
 * Class AimsService
 *
 * @package App\Http\Services\Aims360
 */
class AimsStyleService extends BaseService
{
    #Api EndPoints For Auth
    const AUTH_END_POINT = '/authentication/v1/authentication/token';
    #Api EndPoints For Styles
    const STYLE_END_POINT = '/StyleColors/v1.1/StyleColors';

    public $httpClient;

    public function __construct()
    {
        parent::__construct();
    }


    /**
     * Get Styles
     *
     * @return bool|\Illuminate\Support\Collection|string
     */
    public function getAims360Styles()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->getBaseUri().self::AUTH_END_POINT,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "client_id=630990B4-BE6E-433E-BFB4-C27972320BAD&client_secret=FNrbPR1wOH3MEkundvLSxxNgfckmes3U1k9CQEbdiWVfLJKBPa&username= shahrooz@aims360.com&password=Api?12345&grant_type=password",
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/x-www-form-urlencoded"
            ),
        ));

        $token = curl_exec($curl);
        curl_close($curl);
        $jsonToken= json_decode($token);

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->getBaseUri().self::STYLE_END_POINT,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer ".$jsonToken->access_token
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        $data = json_decode($response);
        $this->saveProducts($data);

    }


    /**
     *
     *save aims360 products
     *
     * @param $data
     * @retaims360 products $this
     *
     */
    public function saveProducts($data)
    {
        $count = count($data->value);
        for($i=0;$i<$count;$i++)
        {
            $flag = Aims360_Product::where('styleColorID', $data->value[$i]->styleColorID)->first();
            if(!$flag)
            {
                $a360_products = new Aims360_Product;
                $a360_products->styleColorID = $data->value[$i]->styleColorID;
                $a360_products->style = $data->value[$i]->style;
                $a360_products->color = $data->value[$i]->color;
                $a360_products->description = $data->value[$i]->description;
                $a360_products->save();
            }
        }
        return $this;
    }

    public function getToken()
    {
        return  $this->token();
       return $this->setHeaders($this->token())->post('https://public-api.shiphero.com/graphql', $options);
    }

}
