<?php

namespace Omnipay\ZaloPay\Message\AllInOne;

use Omnipay\ZaloPay\Message\AbstractRedirectResponse;

/**
 * PayPal Express Authorize Response
 */
class PurchaseResponse extends AbstractRedirectResponse
{
    public function isRedirect()
    {
        $isSuccess = $this->getReturnCode() == 1;

        return $isSuccess && $this->getRedirectUrl();
    }

    public function getRedirectUrl()
    {
        return isset($this->data['order_url']) ? $this->data['order_url'] : null;
    }

    public function getRedirectMethod()
    {
        return 'GET';
    }
}
