<?php

namespace App\Services\Payment;

use App\Models\Payment;
use App\Events\PaymentAccepted;
use App\Contracts\Payment as PaymentContract;

class PayeerPayment implements PaymentContract
{
    public function getPaymentUrl($sum, $account)
    {
        Payment::new($account, $sum);

        $m_shop = config('payment.merchants.payeer.id');
        $m_desc = config('payment.merchants.payeer.desc');
        $m_key = config('payment.merchants.payeer.key');
        $m_curr = 'RUB';
        $m_orderid = $account;
        $m_amount = number_format($sum, 2, '.', '');

        $arHash = array(
            'm_shop' => $m_shop,
            'm_orderid' => $m_orderid,
            'm_amount' => $m_amount,
            'm_curr' => $m_curr,
            'm_desc' => $m_desc,
        );

        $signature = strtoupper(hash('sha256', implode(':', $arHash) . ':' . $m_key));

        $arHash['m_sign'] = $signature;

        return $url = config('payment.merchants.payeer.url') .
            http_build_query($arHash);
        
    }

    public function confirmPayment($data)
    {
        $paymentId = $data['m_orderid'];

        $payment = Payment::find($paymentId);

        if (!$payment) {

            return ['error' => [
                'message' => 'INVALID ORDER ID'
            ]];
        }

        $request = [];
        $request = $this->parseRequest($data);

        if (!$request['sign']) {

            return response($paymentId . '|error', 200)->header('Content-Type', 'text/plain');
        }

        if ($payment->status !== Payment::STATUS_NEW) {
            if ($payment->status === Payment::STATUS_CONFIRMED) {

                return response($paymentId . '|success', 200)->header('Content-Type', 'text/plain');
            }

            if ($payment->status == Payment::STATUS_ERROR) {

                return response($paymentId . '|error', 200)->header('Content-Type', 'text/plain');
            }
        }


        if ($request['amount'] != $payment->amount) {
            
            return response($paymentId . '|error', 200)->header('Content-Type', 'text/plain');
        }

        $payment->status = Payment::STATUS_CONFIRMED;
        $payment->merchant_id = $request['intid'];
        $payment->save();

        $user = $payment->user;

        $user->increment('balance', $payment->amount);

        $user->save();

        event(new PaymentAccepted($user, $payment->amount));

        return response($paymentId . '|success', 200)->header('Content-Type', 'text/plain');
    }

    private function parseRequest($data)
    {
        $m_key = config('payment.merchants.payeer.key');

        $arHash = array(
            $data['m_operation_id'],
            $data['m_operation_ps'],
            $data['m_operation_date'],
            $data['m_operation_pay_date'],
            $data['m_shop'],
            $data['m_orderid'],
            $data['m_amount'],
            $data['m_curr'],
            $data['m_desc'],
            $data['m_status']
        );

        if (isset($data['m_params'])) {
            $arHash[] = $data['m_params'];
        }

        $arHash[] = $m_key;

        $sign_hash = strtoupper(hash('sha256', implode(':', $arHash)));

        return [
            'sign' => $data['m_sign'] == $sign_hash && $data['m_status'] == 'success',
            'amount' => $data['m_amount'],
            'intid' => $data['m_operation_id'],
        ];
    }
}