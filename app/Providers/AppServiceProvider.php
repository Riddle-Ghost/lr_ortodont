<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

        $this->app->bind( \App\Contracts\Payment::class, function($app) {

            $paymentMerchant = ucfirst( mb_strtolower(config('payment.activeMerchant')) );
            return $app->make(
                '\\App\\Services\\Payment\\' . $paymentMerchant . 'Payment'
            );
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
