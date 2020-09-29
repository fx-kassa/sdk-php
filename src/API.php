<?php

namespace Flamix\Kassa;

use Flamix\Kassa\Actions\Recurrent;
use \GuzzleHttp\Client as Http,
    \Exception,
    Flamix\Kassa\Actions\Payments;

class API
{
    use Payments;
    use Recurrent;

    private $api_domain = 'https://kassa.flamix.solutions/api/cashbox/',
            $headers    = array(),
            $query      = array(),
            $publick_key,
            $secret_key;

    public function __construct( string $publick_key, string $secret_key = '' )
    {
        $this->publick_key = $publick_key;
        $this->secret_key  = $secret_key;
    }

    /**
     * Return array of Headers prepared to GUZZLE request
     *
     * @return array
     */
    public function getHeaders()
    {
        $header = array();
        if(!empty($this->headers))
            $header['headers'] = $this->headers;

        if(!empty($this->query))
            $header['query'] = $this->query;

        return $header;
    }

    /**
     * @param string $name
     * @param $value
     */
    public function setHeader( string $name, $value )
    {
        $this->headers[$name] = $value;
    }

    /**
     * @param string $name
     * @param $value
     */
    public function setQuery( string $name, $value )
    {
        $this->query[$name] = $value;
    }

    /**
     * Set Bearer auth token (if need)
     */
    public function setBearerHeader()
    {
        if(!empty($this->secret_key))
            $this->setHeader('Authorization', 'Bearer ' . $this->secret_key);
    }

    /**
     * Create URL to send request
     *
     * @param $url
     * @return string
     */
    public function getURL( $url )
    {
        return $this->publick_key . '/' . $url;
    }

    /**
     * Send request to API
     *
     * @param string $url
     * @param string $type
     * @return mixed
     * @throws \Exception
     */
    public function exec( string $url, string $type = 'GET' )
    {
        $http = new Http(['base_uri' => self::$api_domain]);
        $this->setBearerHeader();

        $responce = $http->request( $type, $this->getURL($url), $this->getHeaders());

        if($responce->getStatusCode() != '200')
            throw new Exception('API is not available!');

        if($responce->getHeaderLine('Content-Type') != 'application/json')
            throw new Exception('API must return JSON!');

        $json = json_decode($responce->getBody()->getContents(), true);

        if(json_last_error())
            throw new Exception('Bad JSON format');

        if(!$json['success'])
            throw new Exception($json['message']);

        return $json;
    }
}