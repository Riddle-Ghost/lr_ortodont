<?php

namespace App\Services\Payment;

use App\Contracts\Payment as PaymentContract;
use App\Models\Payment;
use App\Events\PaymentAccepted;

class RobokassaPayment implements PaymentContract
{
    public function getPaymentUrl($sum, $account)
    {
        Payment::new($account, $sum);

        $merchant_login = config('payment.merchants.robokassa.id');
        $secret = config('payment.merchants.robokassa.secret1');
        $desc = config('payment.merchants.robokassa.desc');

        $signature = md5("$merchant_login:{$sum}:{$account}:$secret");

        return $url = config('payment.merchants.robokassa.url') .
            http_build_query([
                'MrchLogin' => $merchant_login,
                'OutSum' => $sum,
                'InvId' => $account,
                'Desc' => $desc,
                'SignatureValue' => $signature,
            ]);
        
    }

    public function confirmPayment($data)
    {
        $paymentId = $data['InvId'];

        $payment = Payment::find($paymentId);

        if (!$payment) {

            return ['error' => [
                'message' => 'INVALID ORDER ID'
            ]];
        }

        $request = [];
        $request = $this->parseRequest($data);

        if (!$request['sign']) {

            return response('error|INVALID SIGN', 200)->header('Content-Type', 'text/plain');
        }

        if ($payment->status !== Payment::STATUS_NEW) {
            if ($payment->status === Payment::STATUS_CONFIRMED) {

                return response('OK' . $paymentId, 200)->header('Content-Type', 'text/plain');
            }

            if ($payment->status == Payment::STATUS_ERROR) {

                return response('error|fail', 200)->header('Content-Type', 'text/plain');
            }
        }


        if ($request['amount'] != $payment->amount) {
            
            return response('error|fail', 200)->header('Content-Type', 'text/plain');
        }

        $payment->status = Payment::STATUS_CONFIRMED;
        $payment->merchant_id = $request['intid'];
        $payment->save();

        $user = $payment->user;

        $user->increment('balance', $payment->amount);

        $user->save();

        event(new PaymentAccepted($user, $payment->amount));

        return response('OK' . $paymentId, 200)->header('Content-Type', 'text/plain');
    }

    private function parseRequest($data)
    {
        $amount = $data['OutSum'];
        $paymentId = $data['InvId'];
        $signature = strtoupper($data['SignatureValue']);
        $secret = config('payment.merchants.robokassa.secret2');

        $calcSignature = strtoupper(md5("$amount:$paymentId:$secret"));


        if ($calcSignature !== $signature) {
            return ['sign' => false];
        };

        return [
            'sign' => true,
            'amount' => $amount,
            'intid' => $paymentId,
        ];
    }
}