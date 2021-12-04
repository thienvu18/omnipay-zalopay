<?php
require '../vendor/autoload.php';

use Money\Currency;
use Money\Money;
use Omnipay\Common\PaymentMethod;
use Omnipay\Omnipay;

$gateway = Omnipay::create('ZaloPay_AllInOne');
$gateway->initialize([
    'app_id' => 2553,
    'key1' => 'PcY4iZIKFCIdgZvA6ueMcMHHUbRLYjPL',
    'key2' => 'kLtgPl8HHhfvMuDHPwKfgfsY4Ydm9eIz',
    'app_user' => 'Merchant Trial V2',
    'test_mode' => true,
]);

$response = $gateway->purchase([
    'amount' => '20000',
    'currency' => 'VND',
    // 'order_id' => 'ORD004',
    'items' => [
        [
            'name' => 'Macbook Pro',
            'quantity' => 1,
            'price' => 20000,
        ]
    ],
    'payment_method' => 'zalopayapp',
    'description' => 'Thanh toan cho don hang ORD004'
])->send();

if ($response->isSuccessful()) {
    // payment was successful: update database
    print_r($response);
} elseif ($response->isRedirect()) {
    echo 'transaction_id: ' . $response->getTransactionId();
    // redirect to offsite payment gateway
    echo "\n" . $response->getRedirectUrl() ?? 'RedirectURL';
} else {
    // payment failed: display message to customer
    echo $response->getMessage() ?? 'Error here';
    echo $response->getSubMessage() ?? 'Error detail here';
}
