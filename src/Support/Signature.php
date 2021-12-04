<?php

namespace Omnipay\ZaloPay\Support;

class Signature
{
    /**
     * Khóa bí mật dùng để tạo và kiểm tra chữ ký dữ liệu.
     *
     * @var string
     */
    protected $secretKey;

    /**
     * Khởi tạo đối tượng DataSignature.
     *
     * @param  string  $secretKey
     */
    public function __construct(string $secretKey)
    {
        $this->secretKey = $secretKey;
    }

    /**
     * Trả về chữ ký dữ liệu của dữ liệu truyền vào.
     *
     * @param  array  $data
     * @return string
     */
    public function generate(string $data): string
    {
        return hash_hmac('sha256', $data, $this->secretKey);
    }

    /**
     * Kiểm tra tính hợp lệ của chữ ký dữ liệu so với dữ liệu truyền vào.
     *
     * @param  string  $data
     * @param  string  $expect
     * @return bool
     */
    public function validate(string $data, string $expect): bool
    {
        $actual = $this->generate($data);

        return 0 === strcasecmp($expect, $actual);
    }
}
