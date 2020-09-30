<?php

namespace Flamix\Kassa\Actions;

use \Exception;

trait Check
{
    public  $cachbox_code,
            $order_id,
            $custom_info,
            $amount,
            $request_amount,
            $cashbox_currency,
            $payment_currency,
            $contact,
            $transaction_id;

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
        $this->cashbox_currency = mysql_real_escape_string($request['cashbox_currency']);
        $this->payment_currency = mysql_real_escape_string($request['payment_currency']);

        $this->transaction_id   = (int) $request['transaction_id'];
        $this->order_id         = mysql_real_escape_string($request['order_id']);
        $this->custom_info      = mysql_real_escape_string($request['custom_info']);

        $this->cachbox_code     = mysql_real_escape_string($request['cachbox_code']);
        $this->contact          = mysql_real_escape_string($request['contact']);

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

        return hash('sha256', $request['cashbox_code'] . '&' . $request['order_id'] . '&' . $request['transaction_id'] . '&' . $request['request_amount'] . '&' . $request['amount'] . '&' . $request['contact'] . '&' . $request['payment_code'] . '&' . $request['cashbox_currency'] . '&' . $request['payment_currency'] . '&' . $request['custom_info'] . '&' . $this->secret_key );
    }
}