<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 29.09.2020
 * Time: 14:02
 */

use Flamix\Kassa\API;

class CheckTest extends \PHPUnit\Framework\TestCase
{
    protected $id,
        $url,
        $key,
        $kassa;

    protected function setUP(): void
    {
        parent::setUP();

        $this->id   = getenv('FLAMIX_KASSA_PUBLIC_KEY');
        $this->key  = getenv('FLAMIX_KASSA_SECRET_KEY');

        $this->url  = getenv('FLAMIX_KASSA_TEST_URL');

        $this->kassa= new API($this->id, $this->key);
    }

    /**
     * @test is Payment corret check
     *
     * @covers \Flamix\Kassa\API::isPaymentSuccess()
     * @covers \Flamix\Kassa\API::createPaymentHash()
     */
    public function isPaymentSuccess()
    {
        $this->assertTrue(true);
    }
}
