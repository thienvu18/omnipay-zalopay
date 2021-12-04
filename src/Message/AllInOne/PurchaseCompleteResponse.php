<?php

namespace Omnipay\ZaloPay\Message\AllInOne;

use Omnipay\Common\Message\AbstractResponse;


class PurchaseCompleteResponse extends AbstractResponse
{
    public function isSuccessful()
    {
        return isset($this->data['status']) ? $this->data['status'] == 1 : false;
    }

    public function isRedirect()
    {
        return false;
    }

    public function isPending()
    {
        return isset($this->data['status']) ? $this->data['status'] == 3 : false;
    }

    public function getTransactionReference()
    {
        return null;
    }

    /**
     * Response Message
     *
     * @return null|string A response message from the payment gateway
     */
    public function getMessage()
    {
        return null;
    }

    /**
     * Response code
     *
     * @return null|string A response code from the payment gateway
     */
    public function getCode()
    {
        return isset($this->data['status']) ? $this->data['status'] : null;
    }

    public function getTransactionId()
    {
        return $this->data['app_trans_id'] ?? null;
    }

    public function getDiscountAmount()
    {
        return isset($this->data['discount_amount']) ? $this->data['discount_amount'] : 0;
    }

    public function getAmount()
    {
        return isset($this->data['amount']) ? $this->data['amount'] : 0;
    }

    public function getPmcid()
    {
        return isset($this->data['pmcid']) ? $this->data['pmcid'] : null;
    }

    public function getBankCode()
    {
        return isset($this->data['bank_code']) ? $this->data['bank_code'] : null;
    }
}
