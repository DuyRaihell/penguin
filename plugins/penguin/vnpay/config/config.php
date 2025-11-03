<?php

return [
    'vnp_TmnCode'    => env('VNPAY_TMN_CODE', ''),
    'vnp_HashSecret' => env('VNPAY_HASH_SECRET', ''),
    'vnp_Url'        => env('VNPAY_URL', 'https://sandbox.vnpayment.vn/paymentv2/vpcpay.html'),
    'vnp_ReturnUrl'  => env('VNPAY_RETURN_URL', 'http://localhost:8080/vnpay/return'),
    'vnp_ExpireAfterMinutes' => env('VNPAY_EXPIRE_AFTER', 15), // link expires in 15 minutes
];
