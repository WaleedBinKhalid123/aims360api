<?php

namespace App\Http\Services\Aims360;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Http;

/**
 * Class AimsService
 *
 * @package App\Http\Services\Aims360
 */
class AimsStyleService extends BaseService
{

    #Api EndPoints
    const STYLE_END_POINT = 'StyleColors/v1.1/StyleColors';

    public $httpClient;

    public function __construct()
    {
        parent::__construct();
//        $this->httpClient = $client;
    }


    /**
     * Get Styles
     *
     * @return bool|\Illuminate\Support\Collection|string
     */
    public function getAims360Styles()
    {
        return $this->setHeaders($this->getApiBearerToken())->post($this->getBaseUri().self::STYLE_END_POINT);
    }

    public function getToken()
    {
        return  $this->token();
//        dd('https://public-api.shiphero.com/graphql?'.$query);
//        dd(http_build_url($query));
       return $this->setHeaders($this->token())->post('https://public-api.shiphero.com/graphql', $options);
    }

}
