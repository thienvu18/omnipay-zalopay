<?php

namespace Omnipay\ZaloPay\Support;

class Helper
{
    public static function createTransactionIdPrefix()
    {
        $now = new \DateTime('now', new \DateTimeZone('Asia/Ho_Chi_Minh'));
        return $now->format('ymdHisvu');
    }

    public static function createAppTime()
    {
        $now = new \DateTime();
        return $now->getTimestamp() * 1000;
    }
}
