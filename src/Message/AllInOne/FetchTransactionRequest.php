<?php

namespace Omnipay\ZaloPay\Message\AllInOne;

use Omnipay\ZaloPay\Message\AbstractRequest;
use Omnipay\ZaloPay\Message\AllInOne\PurchaseResponse;

class FetchTransactionRequest extends AbstractRequest
{
    public function getEndpoint()
    {
        return parent::getEndpoint() . '/query';
    }

    /**
     * {@inheritdoc}
     */
    protected function getSignatureData(): string
    {
        return "{$this->getAppId()}|{$this->getTransactionId()}|{$this->getKey1()}";
    }

    public function createResponse($data)
    {
        return $this->response = new FetchTransactionResponse($this, $data);
    }

    protected function getRequiredParams(): array
    {
        return [
            'app_id',
            'app_trans_id',
            'mac',
        ];
    }

    public function getData()
    {
        $data = [];

        $data['app_id'] = $this->getAppId();
        $data['app_trans_id'] = $this->getTransactionId();
        $data['mac'] = $this->getSignature();

        return $data;
    }
}
