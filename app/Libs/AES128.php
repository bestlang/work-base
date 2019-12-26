<?php
namespace App\Libs;

class AES128 {
    /**
     *
     * @param string $string 需要加密的字符串
     * @param string $key 密钥
     * @return string
     */
    public static function encrypt($string, $key)
    {
        // openssl_encrypt 加密不同Mcrypt，对秘钥长度要求，超出16加密结果不变
        $data = openssl_encrypt($string, 'AES-128-ECB', $key, OPENSSL_NO_PADDING);

        $data = strtoupper(bin2hex($data));

        return $data;
    }


    /**
     * @param string $string 需要解密的字符串
     * @param string $key 密钥
     * @return string
     */
    public static function decrypt($string, $key)
    {
        $decrypted = openssl_decrypt(hex2bin($string), 'AES-128-ECB', $key, OPENSSL_NO_PADDING);

        $decrypted = strtoupper(bin2hex($decrypted));
        return $decrypted;
    }
}