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

        $this->id       = getenv('FLAMIX_KASSA_PUBLIC_KEY');
        $this->key      = getenv('FLAMIX_KASSA_API_KEY');
        $this->secret   = getenv('FLAMIX_KASSA_SECRET_KEY');

        $this->url      = getenv('FLAMIX_KASSA_TEST_URL');

        $this->kassa    = new API($this->id, $this->key);
    }

    /**
     * @test is Payment corret check
     *
     * @covers \Flamix\Kassa\API::isPaymentSuccess()
     * @covers \Flamix\Kassa\API::createPaymentHash()
     */
    public function isPaymentSuccess()
    {
        $test_array = array(
            'cashbox_code'      => $this->id,
            'order_id'          => 11,
            'transaction_id'    => '',
            'request_amount'    => 11,
            'amount'            => 10.94,
            'contact'           => '',
            'payment_code'      => 'test',
            'cashbox_currency'  => 'UAH',
            'payment_currency'  => 'UAH',
            'custom_info'       => 11,
            'sha256_hash'       => 'f5912e71b0583b71ee1ad2ff570f6c0ef833f34b088460c76bffa960c6f96eed',
            'checkHashStr'      => '01ekydc2swcp16psjrtrnrbc6x&11&&11&10.94&&test&UAH&UAH&11&tiy1opG9CJ0vmTtn',
        );

        $isCheckSuccess = $this->kassa->setSecretKey($this->secret)->isPaymentSuccess($test_array);

        $this->assertFalse($isCheckSuccess, 'Wrong SECRET_KEY or ALGORITHM');
        $this->assertNotEquals($this->kassa->amount, $test_array['amount']);
    }
}
