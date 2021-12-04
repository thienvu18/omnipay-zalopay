<?php

namespace Omnipay\ZaloPay\Message\AllInOne;

use Omnipay\Common\PaymentMethod;
use Omnipay\ZaloPay\Message\AbstractRequest;
use Omnipay\ZaloPay\Message\AllInOne\PurchaseResponse;

class CallbackReturnRequest extends AbstractRequest
{
    public function getIsSuccess(): bool
    {
        return $this->getParameter('is_success') ?? true;
    }

    public function setIsSuccess(bool $value)
    {
        return $this->setParameter('is_success', $value);
    }

    public function getMessage(): string
    {
        return $this->getParameter('message');
    }

    public function setMessage(string $value)
    {
        return $this->setParameter('message', $value);
    }

    /**
     * {@inheritdoc}
     */
    protected function getSignatureData(): string
    {
        return "";
    }

    public function createResponse($data)
    {
        return $this->response = new CallbackReturnResponse($this, $data);
    }

    protected function getRequiredParams(): array
    {
        return [
            'is_success',
            'message',
        ];
    }

    public function getData()
    {
        $data = [];

        $data['return_code'] = $this->getIsSuccess();
        $data['return_message'] = $this->getMessage();

        return $data;
    }
}
