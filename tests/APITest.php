<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 29.09.2020
 * Time: 14:02
 */

use Flamix\Kassa\API;

class APITest extends \PHPUnit\Framework\TestCase
{
    protected $id,
              $url,
              $key,
              $secret,
              $kassa;

    protected function setUP(): void
    {
        parent::setUP();

        $this->id       = getenv('FLAMIX_KASSA_PUBLIC_KEY');
        $this->key      = getenv('FLAMIX_KASSA_API_KEY');
        $this->secret   = getenv('FLAMIX_KASSA_SECRET_KEY');

        $this->url      = getenv('FLAMIX_KASSA_TEST_URL');

        $this->kassa    = new API($this->id, $this->key);
    }

    /**
     * Test PING
     */
    public function testPingApiSites()
    {
        exec('ping -c 2 pay.flamix.solutions', $output, $status);
        $this->assertFalse((bool) $status, 'API site doesnt responce');

        exec('ping -c 2 kassa.flamix.solutions', $output, $status);
        $this->assertFalse((bool) $status, 'MAIN site doesnt responce');
    }

    /**
     * Test Headers
     *
     * @test
     * @covers \Flamix\Kassa\API::getHeaders()
     * @covers \Flamix\Kassa\API::setQuery()
     * @covers \Flamix\Kassa\API::setHeader()
     */
    public function testHeaders()
    {
        $kassa = new API($this->id, $this->key);

        $kassa->setHeader('test', 'Y');
        $result = $kassa->getHeaders();
        $expected = array();
        $expected['headers']['test'] = 'Y';

        $this->assertTrue($expected['headers']['test'] === $result['headers']['test']);

        $kassa->setQuery('test', 'Y');
        $result = $kassa->getHeaders();
        $expected['query']['test'] = 'Y';

        $this->assertTrue($expected['query']['test'] === $result['query']['test']);
    }

    /**
     * @test URL
     *
     * @covers \Flamix\Kassa\API::getDomain()
     * @covers \Flamix\Kassa\API::changeDomain()
     * @covers \Flamix\Kassa\API::getURL()
     */
    public function testDomainAndURL()
    {
        $kassa = new API($this->id, $this->key);

        $this->assertEquals($kassa->getDomain(), 'https://kassa.flamix.solutions/api/cashbox/');
        $headers = @get_headers($kassa->getDomain() . $kassa->getURL('getPayments'));
        $this->assertEquals($headers['0'], 'HTTP/1.1 200 OK', 'MAIN DOMAIN NOT AVAILABLE');

        //TEST domanin
        $kassa->changeDomain($this->url);
        $this->assertEquals($kassa->getDomain(), $this->url);

        $headers = @get_headers($kassa->getDomain() . $kassa->getURL('getPayments'));
        $this->assertEquals($headers['0'], 'HTTP/1.1 200 OK', 'TEST DOMAIN NOT AVAILABLE');
    }
}
