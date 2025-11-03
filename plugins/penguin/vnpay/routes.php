<?php

use Illuminate\Support\Facades\Route;
use Penguin\Vnpay\Classes\VnpayService;

Route::get('/vnpay/pay/{orderId}', function ($orderId) {
    $service = new VnpayService();
    $url = $service->createPaymentUrl($orderId, 50000, "Test order #$orderId");
    return redirect($url);
});

