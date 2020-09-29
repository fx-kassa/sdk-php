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
    protected   $id,
                $key,
                $kassa;

    protected function setUP(): void
    {
        parent::setUP();

        $this->id   = getenv('FLAMIX_KASSA_ID');
        $this->key  = getenv('FLAMIX_KASSA_KEY');

        $this->kassa= new API($this->id, $this->key);
    }

    /**
     * Test Headers
     *
     * @covers \Flamix\Kassa\API::getHeaders()
     * @covers \Flamix\Kassa\API::setQuery()
     * @covers \Flamix\Kassa\API::setHeader()
     */
    public function testHeaders()
    {
        $kassa = new API( $this->id, $this->key );

        $kassa->setHeader('test', 'Y');
        $result = $kassa->getHeaders();
        $expected = array();
        $expected['headers']['test'] = $this->id;

        $this->assertTrue( $expected['headers']['test'] === $result['headers']['test']);

        $kassa->setQuery('test', 'Y');
        $result = $kassa->getHeaders();
        $expected['query']['test'] = 'Y';

        $this->assertTrue( $expected['query']['test'] === $result['query']['test']);
    }
}
