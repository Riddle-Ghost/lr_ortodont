<?php
return [
    'activeMerchant' => env('MERCHANT', 'UNITPAY'),

    'merchants' => [
        'ROBOKASSA' => [
            'driver' => 'robokassa',
            'id' => env('RK_ID'),
            'url' => env('RK_URL', 'https://auth.robokassa.ru/Merchant/Index.aspx?'),
            'apiUrl' => env('RK_API_URL', ''),
            'secret1' => env('RK_SECRET_1'),
            'secret2' => env('RK_SECRET_2')
        ],
        'UNITPAY' => [
            'driver' => 'unitpay',
            'public_key' => env('UP_PUBLIC_KEY'),
            'secret_key' => env('UP_SECRET_KEY'),
            'url' => env('UP_URL', 'https://unitpay.ru/pay/'),
            'desc' => env('UP_DESC', ''),
            'cur' => env('UP_CUR', 'RUB'),
        ],
        'PAYEER' => [
            'driver' => 'payeer',
            'id' => env('PR_ID'),
            'account' => env('PR_ACCOUNT'),
            'key' => env('PR_KEY'),
        ],
    ]
];