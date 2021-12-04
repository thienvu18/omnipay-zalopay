<?php

namespace Omnipay\ZaloPay\Message\AllInOne;

use Omnipay\Common\Exception\InvalidResponseException;
use Omnipay\Common\Message\AbstractRequest as BaseAbstractRequest;
use Omnipay\ZaloPay\Message\AllInOne\PurchaseResponse;

class GetPaymentMethodRequest extends BaseAbstractRequest
{
    protected function getRequiredParams(): array
    {
        return [];
    }

    public function sendData($data)
    {
        return $this->response = new GetPaymentMethodResponse($this, null);
    }

    public function getData()
    {
        return null;
    }
}
