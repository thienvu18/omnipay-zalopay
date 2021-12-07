<?php

namespace Omnipay\ZaloPay\Message;

use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Message\AbstractRequest as BaseAbstractRequest;
use Omnipay\Common\Message\RedirectResponseInterface;
use Omnipay\ZaloPay\Support\Signature;

abstract class AbstractRedirectResponse extends AbstractResponse implements RedirectResponseInterface
{
    /**
     * @inheritDoc
     */
    public function isSuccessful()
    {
        return false;
    }

    /**
     * @inheritDoc
     */
    public function isPending()
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    public function getRedirectData()
    {
        return [];
    }
}
