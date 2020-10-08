<?php

namespace App\Http\Services\Aims360;

/**
 * Class AimsClientService
 *
 * @package App\Http\Services\Aims360
 */
class AimsClientService
{

    /**
     * Curl Channel
     *
     * @var false|resource
     */
    private $_ch;

    /**
     * AimsClientService constructor.
     */
    public function __construct()
    {
        $this->_ch = curl_init();
    }

    /**
     * Get Request
     *
     * @param string $url
     * @param array $data
     *
     * @return \Illuminate\Support\Collection
     */
    public function get(string $url, array $data = null)
    {
        $data = $data != null ? http_build_query($data) : null;
        return $this->_basicCurl($url.'?'.$data);
    }

    /**
     * Post Request
     *
     * @param string $url
     * @param array $data
     *
     * @return bool|string
     */
    public function post(string $url, array $data = null)
    {
        if($data != null) {
//            dd();
            curl_setopt($this->_ch, CURLOPT_POSTFIELDS, $data['json']['query']);
        }

        return $this->_basicCurl($url);
    }

    public function put()
    {

    }

    public function patch()
    {

    }

    public function delete()
    {

    }

    /**
     * Set Headers
     *
     * @param array $headers
     *
     * @return $this
     */
    public function setHeaders(array $headers)
    {
        curl_setopt($this->_ch, CURLOPT_HTTPHEADER, $headers);
        return $this;
    }

    /**
     * Basic CurlSetup
     *
     * @param $url
     *
     * @return \Illuminate\Support\Collection
     */
    private function _basicCurl($url)
    {
        curl_setopt($this->_ch, CURLOPT_URL, $url);
        curl_setopt($this->_ch, CURLOPT_HEADER, 0);
        curl_setopt($this->_ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($this->_ch);
        curl_close($this->_ch);

        return $this->_setResponse($response);
    }

    /**
     * Set Response
     *
     * @param $response
     *
     * @return \Illuminate\Support\Collection
     */
    private function _setResponse($response)
    {
        return collect(json_decode($response));
    }
}
