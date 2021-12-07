<?php

namespace Omnipay\ZaloPay\Message;

use Omnipay\Common\Message\AbstractResponse as BaseAbstractResponse;

abstract class AbstractResponse extends BaseAbstractResponse
{
    /**
     * @return null|int
     */
    public function getReturnCode()
    {
        return isset($this->data['return_code']) ? $this->data['return_code'] : null;
    }

    /**
     * @return null|int
     */
    public function getReturnSubCode()
    {
        return isset($this->data['sub_return_code']) ? $this->data['sub_return_code'] : null;
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
     * @inheritDoc
     */
    public function getTransactionId()
    {
        return $this->getAppTransId();
    }

    public function getAppTransId()
    {
        return $this->data['app_trans_id'] ?? null;
    }

    /**
     * @inheritDoc
     */
    public function getTransactionReference()
    {
        return $this->getZpTransId();
    }

    public function getZpTransId()
    {
        return $this->data['zp_trans_id'] ?? null;
    }
}
