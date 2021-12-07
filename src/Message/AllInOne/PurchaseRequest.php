<?php

namespace Omnipay\ZaloPay\Message\AllInOne;

use Omnipay\Common\PaymentMethod;
use Omnipay\ZaloPay\Message\AbstractRequest;
use Omnipay\ZaloPay\Message\AllInOne\PurchaseResponse;

class PurchaseRequest extends AbstractRequest
{
    public function initialize(array $parameters = array())
    {
        parent::initialize($parameters);

        if (isset($parameters['payment_method'])) {
            $paymentMethod = $parameters['payment_method'];

            $paymentMethodCode = '';
            if ($paymentMethod instanceof PaymentMethod) {
                $paymentMethodCode = $paymentMethod->getId();
            } else {
                $paymentMethodCode = $paymentMethod;
            }

            if ($paymentMethodCode === 'ATM') {
                $this->setBankCode('');

                $embedData = $this->getEmbedData();
                $embedData['bankgroup'] = 'ATM';
                $this->setEmbedData($embedData);
            } else {
                $this->setBankCode($paymentMethodCode);
            }
        }

        return $this;
    }

    public function getAppTime(): int
    {
        return $this->getParameter('appTime');
    }

    public function setAppTime(int $value)
    {
        return $this->setParameter('appTime', $value);
    }

    public function getEmbedData(): array
    {
        return $this->getParameter('embedData') ?? [];
    }

    public function setEmbedData(?array $value)
    {
        return $this->setParameter('embedData', $value);
    }

    public function getDeviceInfo(): array
    {
        return $this->getParameter('deviceInfo') ?? [];
    }

    public function setDeviceInfo(?array $value)
    {
        return $this->setParameter('deviceInfo', $value);
    }

    public function getBankCode(): string
    {
        return $this->getParameter('bankCode') ?? '';
    }

    public function setBankCode(string $value)
    {
        return $this->setParameter('bankCode', $value);
    }

    public function getCallbackUrl(): ?string
    {
        return $this->getParameter('callbackUrl');
    }

    public function setCallbackUrl(?string $value)
    {
        return $this->setParameter('callbackUrl', $value);
    }

    public function getRedirectUrl(): ?string
    {
        return $this->getParameter('redirectUrl');
    }

    public function setRedirectUrl(?string $value)
    {
        $embedData = $this->getEmbedData();
        $embedData['redirecturl'] = $value;
        $this->setEmbedData($embedData);

        return $this->setParameter('redirectUrl', $value);
    }

    public function getSubAppId(): ?string
    {
        return $this->getParameter('subAppId');
    }

    public function setSubAppId(?string $value)
    {
        return $this->setParameter('subAppId', $value);
    }

    public function getTitle(): ?string
    {
        return $this->getParameter('title');
    }

    public function setTitle(?string $value)
    {
        return $this->setParameter('title', $value);
    }

    public function getPhone(): ?string
    {
        return $this->getParameter('phone');
    }

    public function setPhone(?string $value)
    {
        return $this->setParameter('phone', $value);
    }

    public function getEmail(): ?string
    {
        return $this->getParameter('email');
    }

    public function setEmail(?string $value)
    {
        return $this->setParameter('email', $value);
    }

    public function getAddress(): ?string
    {
        return $this->getParameter('address');
    }

    public function setAddress(?string $value)
    {
        return $this->setParameter('address', $value);
    }

    public function getItemsJson(): string
    {
        $itemArray = [];

        if ($items = $this->getItems()) {
            foreach ($items as $item) {
                $itemArray[] = [
                    'name' => $item->getName(),
                    'description' => $item->getDescription(),
                    'quantity' => $item->getQuantity(),
                    'price' => $item->getPrice(),
                ];
            }
        }

        return json_encode($itemArray);
    }

    public function getEmbedDataJson(): string
    {
        return $this->getEmbedData() ? json_encode($this->getEmbedData()) : '{}';
    }

    public function getDeviceInfoJson(): string
    {
        return $this->getDeviceInfo() ? json_encode($this->getDeviceInfo()) : '{}';
    }

    public function getEndpoint(): string
    {
        return parent::getEndpoint() . '/create';
    }

    /**
     * {@inheritdoc}
     */
    protected function getSignatureData(): string
    {
        return "{$this->getAppId()}|{$this->getTransactionId()}|{$this->getAppUser()}|{$this->getAmountInteger()}|{$this->getAppTime()}|{$this->getEmbedDataJson()}|{$this->getItemsJson()}";
    }

    public function createResponse($data): PurchaseResponse
    {
        return $this->response = new PurchaseResponse($this, $data);
    }

    protected function getRequiredParams(): array
    {
        return [
            'app_id',
            'app_user',
            'app_trans_id',
            'app_time',
            'amount',
            'item',
            'description',
            'embed_data',
            'bank_code',
            'mac',
        ];
    }

    public function getData(): array
    {
        $data = [];

        $data['app_id'] = $this->getAppId();
        $data['app_user'] = $this->getAppUser();
        $data['app_trans_id'] = $this->getTransactionId();
        $data['app_time'] = $this->getAppTime();
        $data['amount'] = $this->getAmountInteger();
        $data['item'] = $this->getItemsJson();
        $data['description'] = $this->getDescription();
        $data['embed_data'] = $this->getEmbedDataJson();
        $data['bank_code'] = $this->getBankCode();
        $data['mac'] = $this->getSignature();
        $data['callback_url'] = $this->getCallbackUrl();
        $data['redirect_url'] = $this->getRedirectUrl();
        $data['device_info'] = $this->getDeviceInfoJson();
        $data['sub_app_id'] = $this->getSubAppId();
        $data['title'] = $this->getTitle();
        $data['currency'] = $this->getCurrency();
        $data['phone'] = $this->getPhone();
        $data['email'] = $this->getEmail();
        $data['address'] = $this->getAddress();

        return $data;
    }
}
