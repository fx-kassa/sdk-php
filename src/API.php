<?php

namespace Flamix\Kassa;

use Flamix\Kassa\Actions\{Recurrent, Payments, Check};
use \GuzzleHttp\Client as Http;
use \Exception;

class API
{
    use Check;
    use Payments;
    use Recurrent;

    public  $order_id   = '',
            $amount     = 0,
            $custom_info= '';

    private $api_domain = 'https://kassa.flamix.solutions/api/cashbox/',
            $headers    = [],
            $query      = [],
            $cashbox_code,
            $api_key;

    public function __construct( string $cashbox_code, string $api_key = '' )
    {
        $this->cashbox_code = $cashbox_code;
        $this->api_key = $api_key;
    }

    public function getDomain()
    {
        return $this->api_domain;
    }

    public function changeDomain( string $new_domain )
    {
        $this->api_domain = $new_domain;
        return $this;
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
        if(!empty($this->api_key))
            $this->setHeader('Authorization', 'Bearer ' . $this->api_key);
    }

    /**
     * Create URL to send request
     *
     * @param $url
     * @return string
     */
    public function getURL( $url )
    {
        return $this->cashbox_code . '/' . $url;
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
        $http = new Http(['base_uri' => $this->getDomain()]);

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