<?php

namespace Omnipay\ZaloPay\Message;

use Omnipay\Common\Helper;
use Omnipay\Common\Message\AbstractRequest as BaseAbstractRequest;
use Omnipay\ZaloPay\Support\InputParameterBag;
use Symfony\Component\HttpFoundation\ParameterBag;

abstract class AbstractIncomingRequest extends BaseAbstractRequest
{
    use InputParameterBag;

    /**
     * {@inheritdoc}
     */
    public function initialize(array $parameters = [])
    {
        parent::initialize($parameters);

        $requestData = $this->getAllRequestData();
        $incomingParameters = $this->extractIncomingParameters($requestData);
        Helper::initialize($this, $incomingParameters);

        return $this;
    }

    public function getKey2(): string
    {
        return $this->getParameter('key2');
    }

    public function setKey2(string $value)
    {
        return $this->setParameter('key2', $value);
    }

    /**
     * Trả về danh sách parameters từ ZaloPay gửi sang.
     *
     * @return array
     */
    abstract protected function extractIncomingParameters(ParameterBag $requestData): array;
}
