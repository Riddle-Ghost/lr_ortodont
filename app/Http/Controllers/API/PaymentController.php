<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Contracts\Payment;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public $paymentService;

    public function __construct(Payment $paymentService)
    {
        $this->middleware('auth')->except('confirmPayment');
        $this->middleware('verified')->except('confirmPayment');
        $this->paymentService = $paymentService;
    }

    /**
     * Get payment url.
     *
     * @param int $sum
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPaymentUrl($sum)
    {

        $url = $this->paymentService->getPaymentUrl($sum, Auth::id());

        return response()->json([
            'status' => 'Ok',
            'data' => $url,
        ], 200);
    }

    /**
     * Check payment.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function confirmPayment($request)
    {

        return $this->paymentService->confirmPayment($request->all());
    }
}