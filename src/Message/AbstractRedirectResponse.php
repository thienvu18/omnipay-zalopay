<?php

namespace Omnipay\ZaloPay\Message;

use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Message\AbstractRequest as BaseAbstractRequest;
use Omnipay\Common\Message\AbstractResponse;
use Omnipay\ZaloPay\Support\Signature;

abstract class AbstractRedirectResponse extends AbstractResponse
{
    public function isSuccessful()
    {
        return false;
    }

    public function isPending()
    {
        return true;
    }
}
