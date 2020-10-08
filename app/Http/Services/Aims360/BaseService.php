<?php


namespace App\Http\Services\Aims360;

//use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;

/**
 * Class BaseService
 *
 * @package App\Http\Services\Aims360
 */
abstract class BaseService extends AimsClientService implements IAimsService
{

     # JSON Format
    const JSON = 'json';

     # Authentication EndPoint
    const AUTH_END_POINT = 'authentication/v1/authentication/token';

    /**
     * Load BaseConfig
     *
     * @var \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed
     */
    public $config;

    /**
     * BaseService constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->config = config('aims360');
    }

    /**
     * GetBaseUri
     *
     * @return mixed
     */
    public function getBaseUri()
    {
        return $this->config['api_config']['base_uri'];
    }

    /**
     * @return bool|string
     */
    public function authenticate()
    {
        $res =  $this->setHeaders(["Content-Type: application/x-www-form-urlencoded"])->post($this->getBaseUri().self::AUTH_END_POINT, [
            'username' => $this->config['auth']['username'],
            'password' => $this->config['auth']['password'],
            'grant_type' => 'password',
            'client_id'  => $this->config['api_config']['client_id'],
            'client_secret' => $this->config['api_config']['client_secret']
        ]);
         dd($res);
        }

    /**
     * Get Auth Token
     *
     * @return mixed|null
     */
    public function getToken()
    {
        if(!session()->has('current-expiry') || !session()->has('current-token'))
        {
            $response = $this->authenticate();
            if(!empty($response))
            {
                $response = $this->_setTokenExpiry($response);
                return $response->get('access_token');
            }
        }

        $expiry = session()->get('current-expiry');
        if($expiry > now()->unix()) {
            return session()->get('current-token');
        }

        session()->forget('current-token');
        session()->forget('current-expiry');
        return null;
    }

    /**
     * Return API Headers Token
     *
     * @return array
     */
    public function getApiBearerToken()
    {
        return [
            sprintf("Authorization: Bearer %s", $this->getToken())
        ];

    }
    Public function token()
    {
        return
            sprintf("%s", 'eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCIsImtpZCI6IlJUQXlOVU13T0Rrd09ETXhSVVZDUXpBNU5rSkVOVVUxUmtNeU1URTRNMEkzTWpnd05ERkdNdyJ9.eyJodHRwOi8vc2hpcGhlcm8tcHVibGljLWFwaS9hcHAiOnsibmFtZSI6IlNoaXBoZXJvIFB1YmxpYyBBUEkgR2F0ZXdheSIsImlkIjoibXRjYndxSTJyNjEzRGNPTjNEYlVhSExxUXpRNGRraG4iLCJkYXRhIjp7fX0sImh0dHA6Ly9zaGlwaGVyby1wdWJsaWMtYXBpL3VzZXJpbmZvIjp7Im5hbWUiOiJtZW1iZXJzQHZpcnVzaW50bC5jb20iLCJuaWNrbmFtZSI6Im1lbWJlcnMiLCJwaWN0dXJlIjoiaHR0cHM6Ly9zLmdyYXZhdGFyLmNvbS9hdmF0YXIvMjQwNTdlN2M5NWM1ZWJiZjBhODQ0NmQ0NzczOTdhN2I_cz00ODAmcj1wZyZkPWh0dHBzJTNBJTJGJTJGY2RuLmF1dGgwLmNvbSUyRmF2YXRhcnMlMkZtZS5wbmciLCJhY2NvdW50X2lkIjoiNTc3MzUifSwiaXNzIjoiaHR0cHM6Ly9zaGlwaGVyby5hdXRoMC5jb20vIiwic3ViIjoiYXV0aDB8MTA0OTYxIiwiYXVkIjpbInNoaXBoZXJvLXB1YmxpYy1hcGkiLCJodHRwczovL3NoaXBoZXJvLmF1dGgwLmNvbS91c2VyaW5mbyJdLCJpYXQiOjE2MDIwNzI0MzMsImV4cCI6MTYwNDQ5MTYzMywiYXpwIjoibXRjYndxSTJyNjEzRGNPTjNEYlVhSExxUXpRNGRraG4iLCJzY29wZSI6InByb2ZpbGUgb3BlbmlkIHZpZXc6cHJvZHVjdHMgY2hhbmdlOnByb2R1Y3RzIHZpZXc6b3JkZXJzIGNoYW5nZTpvcmRlcnMgdmlldzpwdXJjaGFzZV9vcmRlcnMgY2hhbmdlOnB1cmNoYXNlX29yZGVycyB2aWV3OnNoaXBtZW50cyBjaGFuZ2U6c2hpcG1lbnRzIHZpZXc6cmV0dXJucyBjaGFuZ2U6cmV0dXJucyB2aWV3OndhcmVob3VzZV9wcm9kdWN0cyBjaGFuZ2U6d2FyZWhvdXNlX3Byb2R1Y3RzIHZpZXc6cGlja2luZ19zdGF0cyB2aWV3OnBhY2tpbmdfc3RhdHMgb2ZmbGluZV9hY2Nlc3MiLCJndHkiOiJwYXNzd29yZCJ9.JkWaOjFs82BsG4gO7N6s_Egi7iMipN4XSRHn6DjOEW7b7YDkdc67PUywNKexHz78KpmcmQGfjgB4w5mDAHZNaV3i8966c0FSiYbBhImsGgEWiicwBqrHpo_Yaw-E7VM2HTG79aPoWxcbTmgSu5dRBOOJdlIhUJCgw8IQHcsl1dD4D_ZLvjah4cQUXWg9xXn6fxOn0ZcrfjCgB8fiVVIUotX6LTHFBeWCLVrjBGImt9QYdltb6kntOLsO5UadYmEY6BIXUqwIyQAubOS3IRSuO1j9q-by3fgqinNklXme9d29946fBYhl6J7Wer3oYu-wkjFHdY0GQ4jvxJ5NWeSuBw')
        ;
    }

    /**
     * Set Current Token Expiry
     *
     * @param $expiry
     *
     * @return \Illuminate\Support\Collection
     */
    private function _setTokenExpiry($expiry)
    {
        session()->put('current-token', $expiry->get('access_token'));
        session()->put('current-expiry', $expiry->get('expires_in'));
        return $expiry;
    }

    public function getAuthentication()
    {
        return $this->authentication();
    }

   public function authentication()
    {
        return $this->setHeaders(["Content-Type: application/json"])->post('https://public-api.shiphero.com/graphql', [

        ]);
    }
}
