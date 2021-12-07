<?php

namespace Omnipay\ZaloPay;

use Omnipay\Common\AbstractGateway;
use Omnipay\ZaloPay\Message\AllInOne\Callback;
use Omnipay\ZaloPay\Message\AllInOne\CallbackReturnRequest;
use Omnipay\ZaloPay\Message\AllInOne\FetchTransactionRequest;
use Omnipay\ZaloPay\Message\AllInOne\GetPaymentMethodRequest;
use Omnipay\ZaloPay\Message\AllInOne\NotificationRequest;
use Omnipay\ZaloPay\Message\AllInOne\PurchaseCompleteRequest;
use Omnipay\ZaloPay\Message\AllInOne\PurchaseRequest;

class AllInOneGateway extends AbstractGateway
{
    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return 'ZaloPay Gateway';
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultParameters()
    {
        return array(
            'app_id' => 0,
            'key1' => '',
            'key2' => '',
            'app_user' => '',
            'test_mode' => true,
        );
    }

    public function getAppId(): int
    {
        return $this->getParameter('appId');
    }

    public function setAppId(int $id)
    {
        return $this->setParameter('appId', $id);
    }

    public function getAppUser(): string
    {
        return $this->getParameter('appUser');
    }

    public function setAppUser(string $value)
    {
        return $this->setParameter('appUser', $value);
    }

    public function getKey1(): string
    {
        return $this->getParameter('key1');
    }

    public function setKey1(string $value)
    {
        return $this->setParameter('key1', $value);
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
     * {@inheritdoc}
     * @return \Omnipay\Common\Message\RequestInterface|PurchaseRequest
     */
    public function purchase(array $options = []): PurchaseRequest
    {
        return $this->createRequest(PurchaseRequest::class, $options);
    }

    /**
     * {@inheritdoc}
     * @return \Omnipay\Common\Message\RequestInterface|PurchaseCompleteRequest
     */
    public function completePurchase(array $options = []): PurchaseCompleteRequest
    {
        return $this->createRequest(PurchaseCompleteRequest::class, $options);
    }

    /**
     * {@inheritdoc}
     * @return \Omnipay\Common\Message\RequestInterface|FetchTransactionRequest
     */
    public function fetchTransaction(array $options = []): FetchTransactionRequest
    {
        return $this->createRequest(FetchTransactionRequest::class, $options);
    }

    public function getPaymentMethods(array $options = []): PurchaseRequest
    {
        return $this->createRequest(GetPaymentMethodRequest::class, $options);
    }

    /**
     * {@inheritdoc}
     * @return \Omnipay\Common\Message\NotificationInterface|Callback
     */
    public function acceptNotification(array $options = array()): \Omnipay\Common\Message\NotificationInterface
    {
        return new Callback($this->httpClient, $this->httpRequest, array_replace($this->getParameters(), $options));
    }
}
