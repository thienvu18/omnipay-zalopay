<?php

namespace Omnipay\ZaloPay\Message\AllInOne;

use Omnipay\ZaloPay\Message\AbstractResponse;

class PurchaseCompleteResponse extends AbstractResponse
{
    public function isSuccessful()
    {
        return $this->getStatus() == 1;
    }

    public function isRedirect()
    {
        return false;
    }

    public function isPending()
    {
        return $this->getStatus() == 3;
    }

    public function getStatus()
    {
        return isset($this->data['status']) ? $this->data['status'] : null;
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
