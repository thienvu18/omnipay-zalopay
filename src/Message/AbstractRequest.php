<?php

namespace Omnipay\ZaloPay\Message;

use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Exception\InvalidResponseException;
use Omnipay\Common\Helper;
use Omnipay\Common\Message\AbstractRequest as BaseAbstractRequest;
use Omnipay\Common\Message\AbstractResponse;
use Omnipay\ZaloPay\Support\Signature;

abstract class AbstractRequest extends BaseAbstractRequest
{
    protected $liveEndpoint = 'https://openapi.zalopay.vn/v2';
    protected $testEndpoint = 'https://sb-openapi.zalopay.vn/v2';

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

    protected function getEndpoint()
    {
        return $this->getTestMode() ? $this->testEndpoint : $this->liveEndpoint;
    }

    abstract protected function getSignatureData(): string;

    public function getSignature()
    {
        $signature = new Signature(
            $this->getKey1()
        );
        $data = $this->getSignatureData();

        return $signature->generate($data);
    }

    abstract protected function createResponse($data);
    abstract protected function getRequiredParams(): array;

    public function sendData($data)
    {
        call_user_func_array([$this, 'validate'], $this->getRequiredParams());

        $httpResponse = $this->httpClient->request('POST', $this->getEndpoint(), [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json; charset=utf-8'
        ], json_encode($data));

        try {
            $body = $httpResponse->getBody()->getContents();
            $returnData = json_decode($body, true);
        } catch (\Throwable $th) {
            throw new InvalidResponseException();
        }

        return $this->createResponse($returnData);
    }

    /**
     * {@inheritdoc}
     */
    public function validate(...$args)
    {
        foreach ($args as $key) {
            $method = 'get' . ucfirst(Helper::camelCase($key));

            if (method_exists($this, $method)) {
                $value = $this->$method();
                if (!isset($value)) {
                    throw new InvalidRequestException("The $key parameter is required");
                }
            }
        }
    }
}
