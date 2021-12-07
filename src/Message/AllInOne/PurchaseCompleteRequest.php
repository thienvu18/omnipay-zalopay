<?php

namespace Omnipay\ZaloPay\Message\AllInOne;

use Omnipay\Common\Exception\InvalidResponseException;
use Omnipay\Common\PaymentMethod;
use Omnipay\ZaloPay\Message\AbstractIncomingRequest;
use Omnipay\ZaloPay\Message\AllInOne\PurchaseResponse;
use Omnipay\ZaloPay\Support\Signature;

class PurchaseCompleteRequest extends AbstractIncomingRequest
{
    protected function extractIncomingParameters($requestData): array
    {
        return [
            'appId' => $requestData->get('appid'),
            'transactionId' => $requestData->get('apptransid'),
            'bankCode' => $requestData->get('bankcode'),
            'pmcid' => $requestData->get('pmcid'),
            'amount' => $requestData->get('amount'),
            'discountAmount' => $requestData->get('discountamount'),
            'status' => $requestData->get('status'),
            'checksum' => $requestData->get('checksum'),
            'currency' => $requestData->get('currency', 'VND'),
        ];
    }

    public function getAppId(): int
    {
        return $this->getParameter('appId');
    }

    public function setAppId(int $id)
    {
        return $this->setParameter('appId', $id);
    }

    public function getPmcid(): string
    {
        return $this->getParameter('pmcid');
    }

    public function setPmcid(string $value)
    {
        return $this->setParameter('pmcid', $value);
    }

    public function getDiscountAmount(): int
    {
        return $this->getParameter('discountAmount');
    }

    public function setDiscountAmount(int $value)
    {
        return $this->setParameter('discountAmount', $value);
    }

    public function getStatus(): int
    {
        return $this->getParameter('status');
    }

    public function setStatus(int $value)
    {
        return $this->setParameter('status', $value);
    }

    public function getBankCode()
    {
        return $this->getParameter('bankCode');
    }

    public function setBankCode(string $value)
    {
        return $this->setParameter('bankCode', $value);
    }

    public function getChecksum(): string
    {
        return $this->getParameter('checksum');
    }

    public function setChecksum(string $value)
    {
        return $this->setParameter('checksum', $value);
    }

    protected function getSignatureData()
    {
        return "{$this->getAppId()}|{$this->getTransactionId()}|{$this->getPmcid()}|{$this->getBankCode()}|{$this->getAmountInteger()}|{$this->getDiscountAmount()}|{$this->getStatus()}";
    }

    public function verifySignature()
    {
        $signature = new Signature(
            $this->getKey2()
        );
        $data = $this->getSignatureData();
        $checksum = $this->getChecksum();

        return $signature->validate($data, $checksum);
    }

    public function getData()
    {
        $data = [];

        $data['app_id'] = $this->getAppId();
        $data['app_trans_id'] = $this->getTransactionId();
        $data['amount'] = $this->getAmountInteger();
        $data['pmcid'] = $this->getPmcid();
        $data['bank_code'] = $this->getBankCode();
        $data['discount_amount'] = $this->getDiscountAmount();
        $data['status'] = $this->getStatus();
        $data['checksum'] = $this->getChecksum();

        return $data;
    }

    public function sendData($data)
    {
        if ($this->verifySignature()) {
            return $this->response = new PurchaseCompleteResponse($this, $data);
        } else {
            throw new InvalidResponseException();
        }
    }
}
