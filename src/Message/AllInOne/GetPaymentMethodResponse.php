<?php

namespace Omnipay\ZaloPay\Message\AllInOne;

use Omnipay\Common\Message\FetchPaymentMethodsResponseInterface;
use Omnipay\Common\PaymentMethod;

class GetPaymentMethodResponse implements FetchPaymentMethodsResponseInterface
{
    public function isRedirect()
    {
        return false;
    }

    public function isSuccessful()
    {
        return true;
    }

    /**
     * Get the returned list of payment methods.
     *
     * These represent separate payment methods which the user must choose between.
     *
     * @return \Omnipay\Common\PaymentMethod[]
     */
    public function getPaymentMethods()
    {
        return [
            new PaymentMethod('zalopayapp', 'ZaloPay'),
            new PaymentMethod('CC', 'Credit Card'),
            new PaymentMethod('ATM', 'ATM'),
        ];
    }
}
