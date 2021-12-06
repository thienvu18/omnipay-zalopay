<?php

namespace Omnipay\ZaloPay\Message\AllInOne;

use Omnipay\ZaloPay\Message\AbstractResponse;

class FetchTransactionResponse extends AbstractResponse
{
    /**
     * @inheritDoc
     */
    public function isSuccessful()
    {
        return true;
    }

    public function getIsProcessing()
    {
        return $this->data['is_processing'] ?? null;
    }

    public function getAmount()
    {
        return $this->data['amount'] ?? null;
    }
}
