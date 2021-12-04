<?php

namespace Omnipay\ZaloPay\Message\AllInOne;

use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Exception\InvalidResponseException;
use Omnipay\Common\Http\ClientInterface;
use Omnipay\Common\Message\NotificationInterface;
use Omnipay\Common\PaymentMethod;
use Omnipay\ZaloPay\Message\AbstractIncomingRequest;
use Omnipay\ZaloPay\Message\AllInOne\PurchaseResponse;
use Omnipay\ZaloPay\Support\Signature;
use Symfony\Component\HttpFoundation\Request as HttpRequest;

class Callback extends AbstractIncomingRequest implements NotificationInterface
{
    public function __construct(ClientInterface $httpClient, HttpRequest $httpRequest, array $parameters = array())
    {
        $this->httpClient = $httpClient;
        $this->httpRequest = $httpRequest;
        $this->initialize($parameters);
    }

    public function initialize(array $parameters = array())
    {
        parent::initialize($parameters);

        if ($this->verifySignature()) {
            return $this;
        } else {
            throw new InvalidResponseException();
        }
    }

    protected function getIncomingParameters(): array
    {
        $data = $this->getAllRequestData();
        $paymentData = json_decode($data->get('data', '{}'), true);

        try {
            return [
                'mac' => $data->get('mac'),
                'type' => $data->get('type'),
                'payment_data' => $data->get('data'),
                'appId' => $paymentData['app_id'],
                'appTransId' => $paymentData['app_trans_id'],
                'appTime' => $paymentData['app_time'],
                'appUser' => $paymentData['app_user'],
                'amount' => $paymentData['amount'],
                'embedData' => json_decode($paymentData['embed_data'], true),
                'item' => json_decode($paymentData['item'], true),
                'zpTransId' => $paymentData['zp_trans_id'],
                'serverTime' => $paymentData['server_time'],
                'channel' => $paymentData['channel'],
                'merchantUserId' => $paymentData['merchant_user_id'],
                'userFeeAmount' => $paymentData['user_fee_amount'],
                'discountAmount' => $paymentData['discount_amount'],
                'currency' => $paymentData['currency'] ?? 'VND',
                'transactionId' => $paymentData['app_trans_id'],
                'transactionReference' => $paymentData['zp_trans_id'],
            ];
        } catch (\Throwable $th) {
            throw new InvalidRequestException();
        }
    }

    public function getMac(): string
    {
        return $this->getParameter('mac');
    }

    public function setMac(string $value)
    {
        return $this->setParameter('mac', $value);
    }

    public function getType(): string
    {
        return $this->getParameter('type');
    }

    public function setType(string $value)
    {
        return $this->setParameter('type', $value);
    }

    public function getPaymentData(): string
    {
        return $this->getParameter('paymentData');
    }

    public function setPaymentData(string $value)
    {
        return $this->setParameter('paymentData', $value);
    }

    public function getAppId(): int
    {
        return $this->getParameter('appId');
    }

    public function setAppId(int $value)
    {
        return $this->setParameter('appId', $value);
    }

    public function getAppTransId(): string
    {
        return $this->getParameter('appTransId');
    }

    public function setAppTransId(string $value)
    {
        return $this->setParameter('appTransId', $value);
    }

    public function getAppTime(): int
    {
        return $this->getParameter('appTime');
    }

    public function setAppTime(int $value)
    {
        return $this->setParameter('appTime', $value);
    }

    public function getAppUser(): string
    {
        return $this->getParameter('appUser');
    }

    public function setAppUser(string $value)
    {
        return $this->setParameter('appUser', $value);
    }

    public function getEmbedData(): array
    {
        return $this->getParameter('embedData') ?? [];
    }

    public function setEmbedData(?array $value)
    {
        return $this->setParameter('embedData', $value);
    }

    public function getZpTransId(): int
    {
        return $this->getParameter('zpTransId');
    }

    public function setZpTransId(int $value)
    {
        return $this->setParameter('zpTransId', $value);
    }

    public function getServerTime(): int
    {
        return $this->getParameter('serverTime');
    }

    public function setServerTime(int $value)
    {
        return $this->setParameter('serverTime', $value);
    }

    public function getChannel(): int
    {
        return $this->getParameter('channel');
    }

    public function setChannel(int $value)
    {
        return $this->setParameter('channel', $value);
    }

    public function getMerchantUserId(): string
    {
        return $this->getParameter('merchantUserId');
    }

    public function setMerchantUserId(string $value)
    {
        return $this->setParameter('merchantUserId', $value);
    }

    public function getUserFeeAmount(): int
    {
        return $this->getParameter('userFeeAmount');
    }

    public function setUserFeeAmount(int $value)
    {
        return $this->setParameter('userFeeAmount', $value);
    }

    public function getDiscountAmount(): int
    {
        return $this->getParameter('discountAmount');
    }

    public function setDiscountAmount(int $value)
    {
        return $this->setParameter('discountAmount', $value);
    }

    public function getItemsJson()
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

    public function getEmbedDataJson()
    {
        return $this->getEmbedData() ? json_encode($this->getEmbedData()) : '{}';
    }

    public function getKey2(): string
    {
        return $this->getParameter('key2');
    }

    public function setKey2(string $value)
    {
        return $this->setParameter('key2', $value);
    }

    protected function getSignatureData()
    {
        return $this->getPaymentData();
    }

    public function verifySignature()
    {
        $signature = new Signature(
            $this->getKey2()
        );
        $data = $this->getSignatureData();
        $checksum = $this->getMac();

        return $signature->validate($data, $checksum);
    }

    public function getData()
    {
        return $this->parameters->all();
    }

    public function sendData($data)
    {
        return  $this;
    }

    /**
     * Was the transaction successful?
     *
     * @return string Transaction status, one of {@link NotificationInterface::STATUS_COMPLETED},
     * {@link NotificationInterface::STATUS_PENDING}, or {@link NotificationInterface::STATUS_FAILED}.
     */
    public function getTransactionStatus()
    {
        return NotificationInterface::STATUS_COMPLETED;
    }

    /**
     * Response Message
     *
     * @return string A response message from the payment gateway
     */
    public function getMessage()
    {
        return null;
    }
}
