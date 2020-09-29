<?php

namespace Flamix\Kassa\Actions;

use \Exception;

trait Payments
{
    private $amount,
            $currency,
            $order_id,
            $custom_info,
            $type = 'link';

    /**
     * Get all avaibel Payment method on Cashbox
     *
     * @return mixed
     * @throws Exception
     */
    public function getCashboxPaymentSystems()
    {
        $responce = $this->exec('getPayments');

        return (!empty($responce['paymentSystems']))? $responce['paymentSystems'] : false;
    }

    /**
     * Return link to request a payment method (Link is default)
     *
     * @return mixed
     * @throws Exception
     */
    public function getPaymentRequest()
    {
        $this->setQuery('type', $this->type);

        if($this->amount)
            $this->setQuery('amount', $this->amount);
        else
            throw new Exception('Bad SUM, use setAmount() method!');

        if($this->currency)
            $this->setQuery('currency', $this->currency);
        else
            throw new Exception('Bad CURRENCY, use setCurrency() method!');

        if($this->order_id)
            $this->setQuery('order_id', $this->order_id);

        if($this->custom_info)
            $this->setQuery('custom_info', $this->custom_info);

        $responce = $this->exec('getPaymentRequest', 'POST');

        return (!empty($responce['response']))? $responce['response'] : false;
    }

    /**
     * Set link type of payment request
     *
     * @param string $type (link, qr, form)
     * @return $this
     */
    public function setPaymentType( string $type )
    {
        $this->type = $type;
        return $this;
    }

    /**
     * Set price/sum
     *
     * @param float $amount
     * @return $this
     */
    public function setAmount( float $amount )
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * Set Currency
     *
     * @param string $currency
     * @return $this
     */
    public function setCurrency( string $currency )
    {
        $this->currency = $currency;
        return $this;
    }

    /**
     * Set uniq order ID if needed
     *
     * @param string $orderId
     * @return $this
     */
    public function setOrderId( string $order_id )
    {
        $this->order_id = $order_id;
        return $this;
    }

    /**
     * Set addition info if needed
     * @param string $customInfo
     * @return $this
     */
    public function setCustomInfo( string $custom_info )
    {
        $this->custom_info = $custom_info;
        return $this;
    }
}