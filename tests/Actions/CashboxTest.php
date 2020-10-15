<?php

use Flamix\Kassa\API;

class CashboxTest extends \PHPUnit\Framework\TestCase
{
    protected $id,
        $url,
        $key,
        $kassa;
    protected function setUP(): void
    {
        parent::setUP();

        $this->id       = getenv('FLAMIX_KASSA_PUBLIC_KEY');
        $this->key      = getenv('FLAMIX_KASSA_API_KEY');
        $this->secret   = getenv('FLAMIX_KASSA_SECRET_KEY');

        $this->url      = getenv('FLAMIX_KASSA_TEST_URL');

        $this->kassa    = new API($this->id, $this->key);
        $this->kassa->changeDomain($this->url);
    }


    /**
     * Test get cash box
     */
    public function testGetCashbox()
    {
        $response = $this->kassa->exec('/', 'GET');
        // print_r($response);
    }


}