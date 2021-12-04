<?php

namespace Omnipay\ZaloPay\Message\AllInOne;

use Omnipay\ZaloPay\Message\AbstractRedirectResponse;

/**
 * PayPal Express Authorize Response
 */
class PurchaseResponse extends AbstractRedirectResponse
{
    public function isRedirect()
    {
        $isSuccess = isset($this->data['return_code']) ? $this->data['return_code'] == 1 : false;

        return $isSuccess && $this->getRedirectUrl();
    }

    public function getRedirectUrl()
    {
        return isset($this->data['order_url']) ? $this->data['order_url'] : null;
    }

    public function getTransactionReference()
    {
        return null;
    }

    public function getRedirectMethod()
    {
        return 'GET';
    }

    /**
     * Response Message
     *
     * @return null|string A response message from the payment gateway
     */
    public function getMessage()
    {
        $msg = isset($this->data['return_message']) ? $this->data['return_message'] : null;
        $subMsg = $this->getSubMessage();

        return $subMsg ? $msg . ': ' . $subMsg : $msg;
    }

    /**
     * Response Sub Message
     *
     * @return null|string A response sub message from the payment gateway
     */
    public function getSubMessage()
    {
        return isset($this->data['sub_return_message']) ? $this->data['sub_return_message'] : null;
    }

    /**
     * Response code
     *
     * @return null|string A response code from the payment gateway
     */
    public function getCode()
    {
        return isset($this->data['return_code']) ? $this->data['return_code'] : null;
    }

    /**
     * Response sub code
     *
     * @return null|string A response sub code from the payment gateway
     */
    public function getSubCode()
    {
        return isset($this->data['sub_return_code']) ? $this->data['sub_return_code'] : null;
    }

    public function getRedirectData()
    {
        return null;
    }

    public function getTransactionId()
    {
        return $this->data['app_trans_id'] ?? null;
    }
}
