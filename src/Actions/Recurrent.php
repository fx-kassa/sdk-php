<?php

namespace Flamix\Kassa\Actions;

use \Exception;

trait Recurrent
{
    private $payment_id,
            $find_by = 'custom_info';

    /**
     * Find Reccurent Payments by musk
     * 
     * @return bool
     * @throws Exception
     */
    public function findReccurentPayment()
    {
        if($this->find_by)
            $this->setQuery('find_by', $this->find_by);

        if($this->order_id)
            $this->setQuery('order_id', $this->order_id);

        if($this->custom_info)
            $this->setQuery('custom_info', $this->custom_info);

        $responce = $this->exec('findSavedMethod', 'POST');

        return (!empty($responce['response']))? $responce['response'] : false;
    }

    /**
     * Try to PAY use Saved Card
     *
     * @return mixed
     * @throws Exception
     */
    public function doReccurentPayment()
    {
        if($this->payment_id)
            $this->setQuery('payment_method_id', $this->payment_id);

        /**
         * If we pay by Payment_id, we dont nedd find payment
         */
        if($this->find_by && empty($this->payment_id)) {
            $this->setQuery('find_by', $this->find_by);

            if(empty($this->order_id) && empty($this->custom_info))
                throw new Exception('You must set order_id or custom_info!');

            if($this->order_id)
                $this->setQuery('order_id', $this->order_id);

            if($this->custom_info)
                $this->setQuery('custom_info', $this->custom_info);
        }

        if($this->amount)
            $this->setQuery('amount', $this->amount);
        else
            throw new Exception('Bad AMOUNT, use setAmount() method!');

        if($this->currency)
            $this->setQuery('currency', $this->currency);
        else
            throw new Exception('Bad CURRENCY, use setCurrency() method!');

        $responce = $this->exec('createAutoTransaction', 'POST');

        return $responce;
    }

    /**
     * Delete Reccurent Paymenats by musk
     *
     * @return mixed
     * @throws Exception
     */
    public function deleteReccurentPayment()
    {
        if($this->find_by)
            $this->setQuery('find_by', $this->find_by);

        if(empty($this->order_id) && empty($this->custom_info))
            throw new Exception('You must set order_id or custom_info!');

        if($this->order_id)
            $this->setQuery('order_id', $this->order_id);

        if($this->custom_info)
            $this->setQuery('custom_info', $this->custom_info);

        $responce = $this->exec('deleteSavedMethod', 'DELETE');

        return $responce;
    }

    /**
     * Chenge find_by musk options
     *
     * @param $find_by Default custom_info
     * @return $this
     */
    public function setFindBy( $find_by )
    {
        $this->find_by = $find_by;
        return $this;
    }

    /**
     * Set ID of Saved Card
     *
     * @param $payment_id
     * @return $this
     */
    public function setPaymentId($payment_id )
    {
        $this->payment_id = $payment_id;
        return $this;
    }
}