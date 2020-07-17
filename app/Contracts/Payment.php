<?php

namespace App\Contracts;

interface Payment {

    public function getPaymentUrl($sum, $account);
    public function confirmPayment($data);
}