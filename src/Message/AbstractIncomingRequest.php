<?php

namespace Omnipay\ZaloPay\Message;

use Omnipay\Common\Helper;
use Omnipay\Common\Message\AbstractRequest as BaseAbstractRequest;
use Omnipay\ZaloPay\Support\InputParameterBag;

abstract class AbstractIncomingRequest extends BaseAbstractRequest
{
    use InputParameterBag;

    /**
     * {@inheritdoc}
     */ 
    public function initialize(array $parameters = [])
    {
        parent::initialize($parameters);

        $incomingParameters = $this->getIncomingParameters();
        Helper::initialize($this, $incomingParameters);

        return $this;
    }

    /**
     * Trả về danh sách parameters từ ZaloPay gửi sang.
     *
     * @return array
     */
    abstract protected function getIncomingParameters(): array;
}
