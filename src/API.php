<?php

namespace Flamix\Kassa;

use \GuzzleHttp\Client as Http,
    \Exception;

class API
{
    const API_URL = 'https://kassa.flamix.solutions/api';

    private $headers = array();
    private $publick_key;
    private $secret_key;

    public function __construct( string $publick_key, string $secret_key = '' )
    {
        $this->$publick_key = $publick_key;
        $this->$secret_key  = $secret_key;
    }

    private function getHeaders()
    {
        return $this->$headers;
    }

    private function setHeader( string $name, $value )
    {
        $this->$headers[$name] = $value;
    }

    private function setBearerHeader()
    {
        $bearer = 'Bearer ' . $this->$publick_key;

        if(!empty($this->$secret_key))
            $bearer .= ':' . $this->$secret_key;

        $this->setHeader('Authorization', $bearer);
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
        $http = new Http(['base_uri' => self::API_URL]);
        $this->setBearerHeader();

        if(empty($this->getHeaders()))
            throw new Exception('Bad headers!');

        $headers = $this->getHeaders();

        $responce = $http->request( $type, $url, array( 'headers' => $headers ));
        return $responce->getBody();
    }
}