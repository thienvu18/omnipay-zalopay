<?php

namespace Omnipay\ZaloPay\Message\AllInOne;

use Omnipay\Common\Message\AbstractResponse;


class CallbackReturnResponse extends AbstractResponse
{
    public function isSuccessful()
    {
        return true;
    }
}
