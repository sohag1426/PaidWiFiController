<?php

use Propaganistas\LaravelPhone\PhoneNumber;

if (!function_exists('validate_mobile')) {

    /**
     * Validate Mobile Number
     *
     * @param string  $mobile_number
     *
     * @return string mobile
     */
    function validate_mobile($mobile_number)
    {
        if (!strlen($mobile_number)) {
            return 0;
        }

        try {
            $first_char = substr($mobile_number, 0, 1);
            if ($first_char == "+") {
                $mobile_number = substr($mobile_number, 1);
            }
            return PhoneNumber::make($mobile_number, config('consumer.country_code'))->formatForMobileDialingInCountry(config('consumer.country_code'));
        } catch (\Throwable $th) {
            return 0;
        }
    }
}


if (!function_exists('sToHms')) {

    /**
     * Seconds to hour minute second
     *
     * @param int  $seconds
     *
     * @return string time
     */
    function sToHms(int $seconds)
    {

        $h = 0;
        $m = 0;
        $s = round($seconds);
        while ($s > 60) {
            $s = $s - 60;
            $m = $m + 1;
        }
        while ($m > 60) {
            $m = $m - 60;
            $h = $h + 1;
        }
        $value = $h . ' Hour ' . $m . ' Minute ' . $s . ' Second ';
        return $value;
    }
}


if (!function_exists('getVarName')) {

    /**
     * Get Variable name from string
     *
     * @param string  $string
     *
     * @return string string
     */
    function getVarName(string $string)
    {

        $string = trim($string);
        $allowed_chars = ['_', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];

        if (strlen($string)) {
            $var = '';
            $chars = str_split($string);
            $len = count($chars);
            for ($i = 0; $i < $len; $i++) {
                if (in_array($chars[$i], $allowed_chars)) {
                    $var .= $chars[$i];
                } else {
                    $var .= '_';
                }
            }
            return $var;
        } else {
            return '';
        }
    }
}


if (!function_exists('getUserName')) {

    /**
     * Get Variable name from string
     *
     * @param string  $string
     *
     * @return string string
     */
    function getUserName(string $string)
    {

        $string = trim($string);

        $allowed_chars = ['+', '@', '.', '_', '-', ':', '/', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];

        if (strlen($string)) {
            $var = '';
            $chars = str_split($string);
            $len = count($chars);
            for ($i = 0; $i < $len; $i++) {
                if (in_array($chars[$i], $allowed_chars)) {
                    $var .= $chars[$i];
                }
            }
            return $var;
        } else {
            return null;
        }
    }
}


if (!function_exists('encryptOrDecrypt')) {
    /**
     * method to encrypt or decrypt a plain text string
     * initialization vector(IV) has to be the same when encrypting and decrypting
     *
     * @param string  $action : can be 'encrypt' or 'decrypt'
     * @param mixed   $data  : value to encrypt or decrypt
     * @return mixed value
     */
    function encryptOrDecrypt($action, $data)
    {
        $output = false;
        $cipher_method = "aes-128-cbc";
        $passphrase = "fPH15ofx1oA7L4OSpNRSCXUzoDbyvU3q";
        $iv_length = openssl_cipher_iv_length($cipher_method);
        $iv = substr(hash('sha256', $passphrase), 0, $iv_length);
        if ($action == 'encrypt') {
            $data  = json_encode($data);
            $output = openssl_encrypt($data, $cipher_method, $passphrase, 0, $iv);
            $output = base64_encode($output);
        } else if ($action == 'decrypt') {
            $output = openssl_decrypt(base64_decode($data), $cipher_method, $passphrase, 0, $iv);
            $output = json_decode($output, true);
        }
        return $output;
    }
}
