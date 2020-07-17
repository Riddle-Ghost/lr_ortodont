<?php

namespace App\Services\Payment;

use App\Contracts\Payment as PaymentContract;
use App\Models\Payment;
use App\Events\PaymentAccepted;

class UnitpayPayment implements PaymentContract
{
    public function getPaymentUrl($sum, $account)
    {
        Payment::new($account, $sum);

        $publicKey = config('payment.merchants.UNITPAY.public_key');
        $secret = config('payment.merchants.UNITPAY.secret_key');
        $desc = config('payment.merchants.UNITPAY.desc');
        $currency = config('payment.merchants.UNITPAY.cur');

        return config('payment.merchants.UNITPAY.url') . $publicKey . "?" .
            http_build_query([
                'sum' => $sum,
                'account' => $account,
                'desc' => $desc,
                'currency' => $currency,
                'signature' => $this->calcSignature(
                    $account,
                    $currency,
                    $desc,
                    $sum,
                    $secret
                )
            ]);
    }
    
    public function confirmPayment($data)
    {
        $paymentId = $data['params']['account'];
        
        $payment = Payment::find($paymentId);

        if (!$payment) {

            return ['error' => [
                'message' => 'INVALID ORDER ID'
            ]];
        }

        if ($data['method'] == 'check') {
            $payment->merchant_id = $data['params']['unitpayId'];
            $payment->status = Payment::STATUS_WAITING;
            $payment->save();

            return ['result' => [
                'message' => 'EVRETHING IS FINE'
            ]];
        }

        if ($data['method'] == 'error') {
            $payment->merchant_id = $data['params']['unitpayId'];
            $payment->status = Payment::STATUS_ERROR;
            $payment->save();

            return ['result' => [
                'message' => 'ERROR ACCEPTED'
            ]];
        }

        if ($data['method'] != 'pay') {
            return ['error' => [
                'message' => 'Unknown method'
            ]];
        }

        $request = [];
        $request = $this->parseRequest($data);

        if (!$request['sign']) {

            return response('INVALID SIGN', 200)->header('Content-Type', 'text/plain');
        }

        if ($payment->status !== Payment::STATUS_NEW) {
            if ($payment->status === Payment::STATUS_CONFIRMED) {

                return response('OK', 200)->header('Content-Type', 'text/plain');
            }

            if ($payment->status == Payment::STATUS_ERROR) {

                return response('fail', 200)->header('Content-Type', 'text/plain');
            }
        }


        if ($request['amount'] != $payment->amount) {
            
            return response('fail', 200)->header('Content-Type', 'text/plain');
        }

        $payment->status = Payment::STATUS_CONFIRMED;
        $payment->merchant_id = $request['intid'];
        $payment->save();

        $user = $payment->user;

        $user->increment('balance', $payment->amount);
        $user->save();

        event(new PaymentAccepted($user, $payment->amount));

        return [
            'result' => [
                'message' => 'Payment confirmed'
            ]
        ];
    }

    private function calcSignature($account, $currency, $desc, $sum, $secretKey)
    {
        $hashStr = $account . '{up}' . $currency . '{up}' . $desc . '{up}' . $sum . '{up}' . $secretKey;
        return hash('sha256', $hashStr);
    }
    
    private function parseRequest($data)
    {
        $secretKey = config('payment.merchants.UNITPAY.secret_key');
        $method = $data['method'];
        $amount = $data['params']['orderSum'];
        $params = $data['params'];
        ksort($params);
        $sign = $params['signature'];
        unset($params['sign']);
        unset($params['signature']);
        array_push($params, $secretKey);
        array_unshift($params, $method);
        $calcSign = hash('sha256', join('{up}', $params));


        if ($calcSign !== $sign) {
            return ['sign' => false];
        };

        return [
            'sign' => true,
            'amount' => $amount,
            'intid' => $params['unitpayId'],
        ];
    }
}