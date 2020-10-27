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
    	$this->kassa->setHeader('Accept', 'application/json');
    }


    /**
     * Test get cash box
     * @test
     * @covers \Flamix\Kassa\API::getCashBox()
     */
    public function testGetCashbox()
    {
        $response = $this->kassa->getCashBox();

        $this->assertArrayHasKey('cashbox', $response, $response['error']);
    }

   //  /**
   //   * Test get cash box
   //   * @test
   //   * @covers \Flamix\Kassa\API::updateCashBox()
   //   */
   //  public function testUpdateCashbox()
   //  {
   //      $response = $this->kassa->updateCashBox([
			// 'user_id' => 2,
			// 'is_email_notify' => 0,
			// 'description' => 'test',
			// 'currency_id' => 1,
			// 'multiple_currencies' => 1,
			// 'is_require_order_id' => 0,
			// 'privacy_politics_url' => 'https://ua.chosten.com/',
			// 'user_terms_url' => 'https://ua.chosten.com/',
			// 'name' => 'test',
			// 'site_url' => 'https://ua.chosten.com/',
			// 'success_url' => 'https://ua.chosten.com/',
			// 'fail_url' => '',
			// 'pending_url' => 'https://ua.chosten.com/',
			// 'interact_url' => 'https://ua.chosten.com/',
			// 'language_id' => 1,
   //      ]);
   //      $this->assertArrayHasKey('cashbox_number', $response, $response['error']);
   //  }

   //  /**
   //   * Test get cash box
   //   * @test
   //   * @covers \Flamix\Kassa\API::deleteCashBox()
   //   */
   //  public function testDeleteCashbox()
   //  {
   //      $response = $this->kassa->deleteCashBox();
   //      $this->assertTrue($response, $response['error']);
   //  }


}