<?php

namespace Flamix\Kassa\Actions;

use \Exception;
use \Flamix\Base\Log;

trait Check
{

    private $secret_key = '';

    private $test_secret_key = '';

    public  $request_amount,
            $cashbox_currency,
            $payment_currency,
            $contact,
            $transaction_id;

    public function setSecretKey( string $secret_key )
    {
        $this->secret_key = $secret_key;
        return $this;
    }

    public function setTestSecretKey( string $test_secret_key )
    {
        $this->test_secret_key = $test_secret_key;
        return $this;
    }

    /**
     * Check payment callback and create all request variable
     *
     * @param array $request
     * @return bool
     * @throws Exception
     */
    public function isPaymentSuccess( array $request )
    {
        if(empty($request['sha256_hash']))
            throw new Exception('Empty sha256 value in $_POST');

        $hash = $this->createPaymentHash($request);

        if($hash !== $request['sha256_hash'])
            return false;

        $this->amount           = (float) $request['amount'];
        $this->request_amount   = (float) $request['request_amount'];
        $this->cashbox_currency = mysqli_real_escape_string($request['cashbox_currency']);
        $this->payment_currency = mysqli_real_escape_string($request['payment_currency']);

        $this->transaction_id   = (int) $request['transaction_id'];
        $this->order_id         = mysqli_real_escape_string($request['order_id']);
        $this->custom_info      = mysqli_real_escape_string($request['custom_info']);

        $this->cashbox_code     = mysqli_real_escape_string($request['cashbox_code']);
        $this->contact          = mysqli_real_escape_string($request['contact']);
        
        return true;
    }

    /**
     * Create sha256 secret hash for payment
     *
     * @param array $request
     * @return string
     * @throws Exception
     */
    private function createPaymentHash( array $request )
    {
        if(empty($this->secret_key))
            throw new Exception('Secret key cant be empty!');

        $finalSecretKey = $requestData['payment_code'] === 'test' ? $this->test_secret_key : $this->secret_key;

        $string = $request['cashbox_code'] . '&' . 
                 $request['order_id'] . '&' . 
                 $request['transaction_id'] . '&' . 
                 $request['request_amount'] . '&' . 
                 $request['amount'] . '&' . 
                 $request['contact'] . '&' . 
                 $request['payment_code'] . '&' . 
                 $request['cashbox_currency'] . '&' . 
                 $request['payment_currency'] . '&' . 
                 $request['custom_info'] . '&' .
                 $finalSecretKey;

        return hash('sha256', $string );
    }
}