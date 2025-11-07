<?php

namespace Penguin\Vnpay\Classes;

class VnpayService
{
    protected $config;

    public function __construct()
    {
        $this->config = config('penguin.vnpay::config');
    }

    public function createPaymentUrl($orderId, $amount, $orderInfo, $returnUrl = null)
    {
        $prefix         = $this->config['vnp_prefix'];
        $vnp_Url        = $this->config['vnp_Url'];
        $vnp_ReturnUrl  = $returnUrl ?? $this->config['vnp_ReturnUrl'];
        $vnp_TmnCode    = $this->config['vnp_TmnCode'];
        $vnp_HashSecret = $this->config['vnp_HashSecret'];
        $vnp_ExpireAfter = $this->config['vnp_ExpireAfterMinutes'];

        $vnp_TxnRef = $prefix.$orderId;
        $vnp_Amount = $amount * 100; // VNPAY uses smallest unit (VND * 100)
        $vnp_OrderInfo = $orderInfo;
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
        $vnp_CreateDate = date('YmdHis');
        $vnp_ExpireDate = date('YmdHis', strtotime("+{$vnp_ExpireAfter} minutes"));

        $inputData = [
            "vnp_Version" => "2.1.0",
            "vnp_Command" => "pay",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_CurrCode" => "VND",
            "vnp_TxnRef" => $vnp_TxnRef,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => "billpayment",
            "vnp_Locale" => "vn",
            "vnp_ReturnUrl" => $vnp_ReturnUrl,
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_CreateDate" => $vnp_CreateDate,
            "vnp_ExpireDate" => $vnp_ExpireDate,
        ];

        ksort($inputData);

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }

        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;

        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret); //  
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }

        return $vnp_Url;
    }

    public function verifyReturn($inputData)
    {
        $vnp_HashSecret = $this->config['vnp_HashSecret'];
        $vnp_SecureHash = $_GET['vnp_SecureHash'];
        $inputData = array();

        foreach ($_GET as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") {
                $inputData[$key] = $value;
            }
        }
        
        unset($inputData['vnp_SecureHash']);
        ksort($inputData);
        $i = 0;
        $hashData = "";

        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData = $hashData . '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashData = $hashData . urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }

        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

        return hash_equals($secureHash, $vnp_SecureHash);
    }
}
