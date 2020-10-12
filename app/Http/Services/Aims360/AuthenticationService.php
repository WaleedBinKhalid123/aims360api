<?php


namespace App\Http\Services\Aims360;

/**
 * Class AuthenticationService
 *
 * @package App\Http\Services\Aims360
 */
class AuthenticationService extends BaseService
{

    /**
     * Authentication EndPoint
     */
   // const AUTH_END_POINT = 'authentication/v1/authentication/token';

    /**
     * Auth User
     *
     * @return \Illuminate\Http\Client\Response
     */
   /* public function authenticate()
    {
        return $this->http::asForm()->post($this->getBaseUri().self::AUTH_END_POINT, [
            'username' => $this->config['auth']['username'],
            'password' => $this->config['auth']['password'],
            'grant_type' => 'password',
            'client_id'  => $this->config['api_config']['client_id'],
            'client_secret' => $this->config['api_config']['client_secret']
        ]);
    }*/
}
