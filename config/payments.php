<?php

return [
    'mercadopago' => [
        'access_token' => env('MERCADOPAGO_ACCESS_TOKEN', ''),
        'base_url' => env('MERCADOPAGO_BASE_URL', 'https://api.mercadopago.com'),
    ],

    'paypal' => [
        'client_id' => env('PAYPAL_CLIENT_ID', ''),
        'secret' => env('PAYPAL_SECRET', ''),
        'base_url' => env('PAYPAL_BASE_URL', 'https://api-m.sandbox.paypal.com'),
    ],

    'transferencia' => [
        'cbu' => env('TRANSFER_CBU', '0000003100000000000000'),
        'alias' => env('TRANSFER_ALIAS', 'LEGADO.PATO.ARS'),
        'receipt_email' => env('TRANSFER_RECEIPT_EMAIL', 'pagos@legadopato.com'),
    ],
];
